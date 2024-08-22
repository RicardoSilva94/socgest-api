<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorenotificacaoRequest;
use App\Http\Requests\UpdatenotificacaoRequest;
use App\Models\Notificacao;
use App\Http\Resources\NotificacaoResource;
use App\Mail\QuotaOverdueNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\Socio;
use App\Models\Quota;
use App\Models\Entidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificacaoController extends Controller
{

    public function sendQuotaNotifications(Request $request)
    {
        $quotaIds = $request->input('quota_ids', []);

        // Buscar quotas com sócio e entidade relacionados
        $quotas = Quota::whereIn('id', $quotaIds)
            ->where('estado', 'Não Pago')
            ->with('socio.entidade') // Carregar a entidade relacionada
            ->get();

        Log::info('Quotas carregadas:', $quotas->toArray());

        foreach ($quotas as $quota) {
            $socio = $quota->socio; // O sócio já tem a entidade carregada

            // Verificar se a entidade está carregada
            if ($socio->entidade) {
                Log::info('Entidade carregada:', [
                    'entidade_id' => $socio->entidade->id,
                    'entidade_nome' => $socio->entidade->nome,
                ]);
            } else {
                Log::warning('Entidade não carregada para o sócio:', ['socio_id' => $socio->id]);
            }

            try {
                // Enviar e-mail
                Mail::to($socio->email)
                    ->cc($socio->entidade->email)
                    ->send(new QuotaOverdueNotification($socio, $quota));

                // Armazenar notificação na base de dados
                Notificacao::create([
                    'quota_id' => $quota->id,
                    'socio_id' => $socio->id,
                    'mensagem' => 'Notificação sobre a quota em atraso.',
                    'estado' => 'enviada',
                    'data_envio' => now(),
                ]);
            } catch (\Exception $e) {
                Log::error("Erro ao enviar e-mail para {$socio->email}: " . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Notificações enviadas com sucesso.']);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return NotificacaoResource::collection(Notificacao::with(['quota', 'socio'])->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorenotificacaoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $notificacao = Notificacao::with(['quota', 'socio'])->findOrFail($id);
        return new NotificacaoResource($notificacao);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(notificacao $notificacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatenotificacaoRequest $request, notificacao $notificacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(notificacao $notificacao)
    {
        //
    }
}
