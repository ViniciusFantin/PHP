<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário Anual</title>
    <style>
        td[data-semana="0"] { color: #ff0000; } /* Estiliza os domingos em vermelho */
        td[data-hoje] { font-weight: bold; } /* Estiliza o dia atual em negrito */
        table { margin-bottom: 20px; }
    </style>
</head>
<body>

    <?php 
    function linha($semana, $diaAtual, $mesAtual)
    {
        $linha = "<tr>";
        for($i = 0; $i <= 6; $i++)
        {
            $dia = isset($semana[$i]) ? $semana[$i] : '';
            $atributo = $i == 0 ? 'data-semana="0"' : ''; // Adiciona atributo para domingos
            $hoje = ($dia == $diaAtual && $mesAtual == 8) ? 'data-hoje' : ''; // Destaca o dia atual apenas em agosto
            $linha .= "<td $atributo $hoje>" . ($hoje ? "<b>$dia</b>" : $dia) . "</td>";
        }
        $linha .= "</tr>"; // Corrigido para fechar a linha corretamente
        return $linha;
    }

    function calendario($mes, $ano, $diaAtual)
    {
        $diasDoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $primeiroDia = date('w', strtotime("$ano-$mes-01")); // 0 = Domingo, 1 = Segunda-feira, etc.

        $calendario = '';
        $dia = 1;
        $semana = array_fill(0, 7, ''); // Inicializa a semana

        // Preenche os dias da semana com as datas do mês
        while ($dia <= $diasDoMes) 
        {   
            // Se não for o primeiro dia, adiciona a data ao array da semana
            if ($dia == 1) {
                for ($i = 0; $i < $primeiroDia; $i++) {
                    $semana[$i] = ''; // Preenche os espaços antes do primeiro dia do mês
                }
            }

            $semana[$primeiroDia] = $dia;
            $primeiroDia++;
            if ($primeiroDia == 7) {
                $calendario .= linha($semana, $diaAtual, $mes);
                $semana = array_fill(0, 7, '');
                $primeiroDia = 0;
            }
            $dia++;
        }

        // Adiciona o restante dos dias da semana
        if (array_filter($semana)) {
            $calendario .= linha($semana, $diaAtual, $mes);
        }
        
        return $calendario;
    }

    function gerarCalendarioAnual($ano)
    {
        $meses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        $html = '';
        $diaAtual = date('j'); // Obtém o dia atual

        foreach ($meses as $mes => $nome) {
            $html .= "<h2>$nome</h2>";
            $html .= "<table border='1'>
                        <thead>
                            <tr>
                                <th>Dom</th>
                                <th>Seg</th>
                                <th>Ter</th>
                                <th>Qua</th>
                                <th>Qui</th>
                                <th>Sex</th>
                                <th>Sab</th>
                            </tr>
                        </thead>
                        <tbody>";
            $html .= calendario($mes, $ano, $diaAtual);
            $html .= "</tbody></table>";
        }

        return $html;
    }

    echo gerarCalendarioAnual(2024); 
    ?>

</body>
</html>
