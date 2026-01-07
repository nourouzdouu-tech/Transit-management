<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatAIController extends Controller
{
 public function ask(Request $request)
{
    $request->validate(['message' => 'required|string']);

    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role'=>'system','content'=>'Vous êtes un assistant expert en transport international.'],
                ['role'=>'user','content'=>$request->message]
            ],
            'temperature' => 0.7,
        ]);

        $reply = $response['choices'][0]['message']['content'] ?? "Pas de réponse.";
        return response()->json(['reply'=>$reply]);

    } catch (\Exception $e) {
    // Affiche l'erreur exacte pour debug
    return response()->json([
        'error_message' => $e->getMessage(),
        'error_trace' => $e->getTraceAsString()
    ], 500);
}

}


}
