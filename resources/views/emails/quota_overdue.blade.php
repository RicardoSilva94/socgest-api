<!DOCTYPE html>
<html>
<head>
    <title>Quota em Atraso</title>
</head>
<body>
<h1>Prezado(a) {{ $socioName }}</h1>

<p>Vimos notificar de que a quota com ID #{{ $quotaId }} no valor de {{ $quotaValue }}€, referente {{ $periodo }}, com a descrição {{ $quotaDescricao }}, encontra-se em atraso.</p>
<p>Data limite para pagamento: {{ $dueDate }}</p>

<p>Por favor, pedimos que regularize a sua situação o quanto antes.</p>

<p>Atenciosamente,<p>
<p>{{ $entidadeNome }}</p>

</body>
</html>
