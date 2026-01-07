<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf; // si tu utilises barryvdh/laravel-dompdf
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dossier;
use App\Models\Historique;
use App\Notifications\DossierUpdated;



class AgentController extends Controller
{
    // Dashboard
 public function dashboard()
{
    $this->authorizeAgent();

    $clients = User::where('role', 'client')->withCount('dossiers')->get();
    $dossiers = Dossier::with('client')->get();
    $agents = User::where('role', 'agent')->get();

    $enCours = $dossiers->where('status', 'En cours')->count();
    $retard = $dossiers->where('status', 'En retard')->count();
    $termine = $dossiers->where('status', 'Terminé')->count();

    // Messages non lus
    $nouveauxMessages = Auth::user()->notificationsNonLues()->count();

    // 📊 Stats par mois et par statut
    $stats = Dossier::selectRaw('MONTH(created_at) as mois, status, COUNT(*) as total')
        ->groupBy('mois', 'status')
        ->orderBy('mois')
        ->get();

    $labels = collect(range(1, 12))->map(function ($m) {
        return \Carbon\Carbon::create()->month($m)->locale('fr')->monthName;
    });

    // Initialiser les séries
    $dataTermine = array_fill(0, 12, 0);
    $dataEnCours = array_fill(0, 12, 0);
    $dataRetard  = array_fill(0, 12, 0);

    foreach ($stats as $stat) {
        $index = $stat->mois - 1;
        if ($stat->status === 'Terminé') {
            $dataTermine[$index] = $stat->total;
        } elseif ($stat->status === 'En cours') {
            $dataEnCours[$index] = $stat->total;
        } elseif ($stat->status === 'En retard') {
            $dataRetard[$index] = $stat->total;
        }
    }

    return view('agent.dashboard', compact(
        'clients',
        'dossiers',
        'agents',
        'enCours',
        'retard',
        'termine',
        'nouveauxMessages',
        'labels',
        'dataTermine',
        'dataEnCours',
        'dataRetard',
    ));
}




    // ----------------------
    // Gestion Clients
    // ----------------------
    public function storeClient(Request $request)
    {
        $this->authorizeAgent();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'ville' => 'nullable|string|max:100',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'ville' => $request->ville,
            'password' => Hash::make($request->password),
            'role' => 'client',
        ]);

        return redirect()->route('agent.dashboard')->with('success', 'Client créé avec succès.');
    }

    public function updateClient(Request $request, $id)
    {
        $this->authorizeAgent();

        $client = User::where('role', 'client')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $client->id,
            'phone' => 'required|string|max:20',
            'ville' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $client->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'ville' => $request->ville,
            'password' => $request->password ? Hash::make($request->password) : $client->password,
        ]);

        return redirect()->route('agent.dashboard')->with('success', 'Client mis à jour avec succès.');
    }

    public function destroyClient($id)
    {
        $this->authorizeAgent();
        $client = User::where('role', 'client')->findOrFail($id);
        $client->delete();

        return redirect()->route('agent.dashboard')->with('success', 'Client supprimé avec succès.');
    }

    // ----------------------
    // Gestion Dossiers
    // ----------------------
   public function storeDossier(Request $request)
{
    $request->validate([
        'numero' => 'required|string|max:50',
        'client_id' => 'required|exists:users,id',
        'agent_id' => 'required|exists:users,id',
        'status' => 'required|string',
        'description' => 'required|string',
        'date_creation' => 'required|date',
        'date_echeance' => 'required|date|after_or_equal:date_creation',
        'priorite' => 'required|string',
    ]);

    Dossier::create($request->all());

    return redirect()->route('agent.dashboard')->with('success', 'Dossier ajouté avec succès');
}


    public function updateDossier(Request $request, $id)
{
    $this->authorizeAgent();

    $dossier = Dossier::findOrFail($id);

    $request->validate([
        'numero' => 'required|string|max:255',
        'client_id' => 'required|exists:users,id',
        'status' => 'required|in:En cours,En retard,Terminé',
        'description' => 'nullable|string',
        'date_creation' => 'required|date',
        'date_echeance' => 'required|date|after_or_equal:date_creation',
        'priorite' => 'required|in:Basse,Moyenne,Haute',
    ]);

    $dossier->update([
        'numero' => $request->numero,
        'client_id' => $request->client_id,
        'agent_id' => auth()->id(), // Agent connecté
        'status' => $request->status,
        'description' => $request->description,
        'date_creation' => $request->date_creation,
        'date_echeance' => $request->date_echeance,
        'priorite' => $request->priorite,
    ]);

    return redirect()->route('agent.dashboard')->with('success', 'Dossier mis à jour avec succès.');
}


    public function destroyDossier($id)
    {
        $this->authorizeAgent();
        $dossier = Dossier::findOrFail($id);
        $dossier->delete();

        return redirect()->route('agent.dashboard')->with('success', 'Dossier supprimé avec succès.');
    }

    // ----------------------
    // Vérification rôle Agent
    // ----------------------
    private function authorizeAgent()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'agent') {
            abort(403, 'Accès refusé.');
        }
    }

    public function dossiersEnRetard()
{
    $this->authorizeAgent();

    $dossiers = Dossier::where('status', 'En retard')->get();

    return view('agent.dossiers_en_retard', compact('dossiers'));
}


/*public function updateStatus(Request $request, Dossier $dossier)
{
    $ancienStatus = $dossier->status;
    $dossier->status = $request->status;
    $dossier->save();

    // Historique
    Historique::create([
        'dossier_id' => $dossier->id,
        'user_id' => auth()->id(),
        'action' => 'Mise à jour du statut',
        'description' => "Le statut est passé de '$ancienStatus' à '{$dossier->status}'",
        'ancien_status' => $ancienStatus,
        'nouveau_status' => $dossier->status,
    ]);


    // Notification au client
    $dossier->client->notify(new DossierUpdated($dossier));

    return back()->with('success', 'Statut mis à jour et historique enregistré.');
}*/
public function updateStatus(Request $request, Dossier $dossier)
{
    $request->validate([
        'status' => 'required|string'
    ]);

    $dossier->status = $request->status;
    $dossier->save(); // l'Observer crée l'historique automatiquement

    // Notifier le client
    $dossier->client->notify(new DossierUpdated($dossier));

    return back()->with('success', 'Statut mis à jour et historique enregistré.');
}

public function exportClientsPdf()
    {
        $clients = User::where('role', 'client')->get();

        $pdf = Pdf::loadView('pdf.clients', compact('clients'));
        return $pdf->download('liste_clients.pdf');
    }

    public function downloadDossiersPDF()
    {
        $dossiers = Dossier::with('client')->get(); // Charger le client lié
        $pdf = PDF::loadView('pdf.dossiers', compact('dossiers'));
        return $pdf->download('liste_colis.pdf');
    }


    public function statistiques()
{
    $dossiers = DB::table('dossiers')
        ->selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();

    $mois = $dossiers->pluck('mois')->map(function($m) {
        return \Carbon\Carbon::create()->month($m)->locale('fr')->monthName;
    });

    $totaux = $dossiers->pluck('total');

    return view('agent.stats', compact('mois', 'totaux'));
}


}
