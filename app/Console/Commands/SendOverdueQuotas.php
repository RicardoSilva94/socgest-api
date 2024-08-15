<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Socio;
use App\Mail\QuotaOverdueNotification;

class SendOverdueQuotas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-overdue-quotas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia notificações de quotas em atraso para os sócios.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now();

        $socios = Socio::whereHas('quotas', function ($query) use ($today) {
            $query->where('data_pagamento', '<', $today->toDateString())
                ->where('estado', 'Não Pago');
        })->get();

        foreach ($socios as $socio) {
            foreach ($socio->quotas as $quota) {
                if ($quota->data_pagamento < $today->toDateString() && $quota->estado == 'Não Pago') {
                    Mail::to($socio->email)->send(new QuotaOverdueNotification($socio, $quota));
                }
            }
        }

        $this->info('Notificações enviadas com sucesso.');
    }
}
