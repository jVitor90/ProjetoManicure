<?php
require_once "banco_class.php";

class relatorios{

    public function TotalHoje(){
        
        $sql = "
        SELECT COALESCE(SUM(servicos.valor), 0) AS total
            FROM agendamento
            INNER JOIN servicos   ON agendamento.id_servico    = servicos.id
            INNER JOIN calendario ON agendamento.id_calendario = calendario.id
            WHERE calendario.data = CURRENT_DATE
              AND agendamento.status = 1
        ";

        $banco = Banco::conectar();

        try{
            $comando = $banco->prepare($sql);
            $comando->execute();
            $linha = $comando->fetch(PDO::FETCH_ASSOC);

            $total = $linha['total'] ?? 0;
            $formatado = number_format($total, 2, ',', '.');

            return $formatado;

        }
        catch(Exception $e){
            return "0,00";
        }
        finally{
            Banco::desconectar();
        }

    }

    public function FaturamentoSemanal(){
        $sql = "
        SELECT COALESCE(SUM(servicos.valor), 0) AS total
        FROM agendamento
        INNER JOIN servicos   ON agendamento.id_servico    = servicos.id
        INNER JOIN calendario ON agendamento.id_calendario = calendario.id
        WHERE calendario.data >= DATE_SUB(CURRENT_DATE, INTERVAL WEEKDAY(CURRENT_DATE) DAY)
          AND calendario.data <= CURRENT_DATE
          AND agendamento.status = 1
        ";

       $banco = Banco::conectar();

        try{
            $comando = $banco->prepare($sql);
            $comando->execute();
            $linha = $comando->fetch(PDO::FETCH_ASSOC);

            $total = $linha['total'] ?? 0;
            $formatado = number_format($total, 2, ',', '.');
            return $formatado;  
        }
        catch(Exception $e){
            error_log("Relatorio::FaturamentoSemanal erro: " . $e->getMessage());
            return "0,00";
        }
        finally{
            Banco::desconectar();
        }
    }

    // Método para obter dados do período selecionado
    public function getDadosPeriodo($periodo = 'mes') {
        $banco = Banco::conectar();
        
        try {
            // Define a data inicial baseada no período
            switch($periodo) {
                case 'semana':
                    $dataInicio = "DATE_SUB(CURRENT_DATE, INTERVAL WEEKDAY(CURRENT_DATE) DAY)";
                    break;
                case 'mes':
                    $dataInicio = "DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')";
                    break;
                case 'trimestre':
                    $dataInicio = "DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)";
                    break;
                case 'ano':
                    $dataInicio = "DATE_SUB(CURRENT_DATE, INTERVAL 12 MONTH)";
                    break;
                default:
                    $dataInicio = "DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')";
            }

            // Receita total do período
            $sqlReceita = "
                SELECT COALESCE(SUM(servicos.valor), 0) AS total
                FROM agendamento
                INNER JOIN servicos ON agendamento.id_servico = servicos.id
                INNER JOIN calendario ON agendamento.id_calendario = calendario.id
                WHERE calendario.data >= $dataInicio
                  AND calendario.data <= CURRENT_DATE
                  AND agendamento.status = 1
            ";
            
            $comando = $banco->prepare($sqlReceita);
            $comando->execute();
            $receita = $comando->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            // Total de atendimentos do período
            $sqlAtendimentos = "
                SELECT COUNT(*) AS total
                FROM agendamento
                INNER JOIN calendario ON agendamento.id_calendario = calendario.id
                WHERE calendario.data >= $dataInicio
                  AND calendario.data <= CURRENT_DATE
                  AND agendamento.status = 1
            ";
            
            $comando = $banco->prepare($sqlAtendimentos);
            $comando->execute();
            $atendimentos = $comando->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            // Clientes novos (cadastrados no período)
            $sqlClientesNovos = "
                SELECT COUNT(DISTINCT u.id) AS total
                FROM usuarios u
                INNER JOIN agendamento a ON u.id = a.id_usuario_agenda
                INNER JOIN calendario c ON a.id_calendario = c.id
                WHERE u.id_tipo = 2
                  AND c.data >= $dataInicio
                  AND c.data <= CURRENT_DATE
                  AND NOT EXISTS (
                      SELECT 1 FROM agendamento a2
                      INNER JOIN calendario c2 ON a2.id_calendario = c2.id
                      WHERE a2.id_usuario_agenda = u.id
                        AND c2.data < $dataInicio
                  )
            ";
            
            $comando = $banco->prepare($sqlClientesNovos);
            $comando->execute();
            $clientesNovos = $comando->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            return [
                'receita' => number_format($receita, 2, ',', '.'),
                'receitaNumero' => $receita,
                'atendimentos' => $atendimentos,
                'clientesNovos' => $clientesNovos
            ];

        } catch(Exception $e) {
            error_log("Erro em getDadosPeriodo: " . $e->getMessage());
            return [
                'receita' => '0,00',
                'receitaNumero' => 0,
                'atendimentos' => 0,
                'clientesNovos' => 0
            ];
        }
        finally{
            Banco::desconectar();
        }
    }

    // Método para obter resumo dos últimos 6 meses
    public function getResumoMeses() {
        $banco = Banco::conectar();
        
        try {
            $meses = [];
            $mesesNomes = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
                          'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
            
            for($i = 5; $i >= 0; $i--) {
                $mesAtual = date('Y-m', strtotime("-$i month"));
                $mesNumero = (int)date('m', strtotime("-$i month"));
                
                // Receita do mês
                $sqlReceita = "
                    SELECT COALESCE(SUM(servicos.valor), 0) AS total
                    FROM agendamento
                    INNER JOIN servicos ON agendamento.id_servico = servicos.id
                    INNER JOIN calendario ON agendamento.id_calendario = calendario.id
                    WHERE DATE_FORMAT(calendario.data, '%Y-%m') = ?
                      AND agendamento.status = 1
                ";
                
                $comando = $banco->prepare($sqlReceita);
                $comando->execute([$mesAtual]);
                $receita = $comando->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

                // Atendimentos do mês
                $sqlAtendimentos = "
                    SELECT COUNT(*) AS total
                    FROM agendamento
                    INNER JOIN calendario ON agendamento.id_calendario = calendario.id
                    WHERE DATE_FORMAT(calendario.data, '%Y-%m') = ?
                      AND agendamento.status = 1
                ";
                
                $comando = $banco->prepare($sqlAtendimentos);
                $comando->execute([$mesAtual]);
                $atendimentos = $comando->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

                // Calcula variação em relação ao mês anterior
                $variacao = 0;
                if($i < 5 && count($meses) > 0) {
                    $receitaAnterior = $meses[count($meses) - 1]['receitaNumero'];
                    if($receitaAnterior > 0) {
                        $variacao = (($receita - $receitaAnterior) / $receitaAnterior) * 100;
                    } elseif($receita > 0) {
                        $variacao = 100; // Se mês anterior era 0 e atual tem receita
                    }
                }

                $meses[] = [
                    'mes' => $mesesNomes[$mesNumero - 1],
                    'receita' => 'R$ ' . number_format($receita, 2, ',', '.'),
                    'receitaNumero' => $receita,
                    'atendimentos' => $atendimentos,
                    'variacao' => $variacao,
                    'variacaoFormatada' => ($variacao > 0 ? '+' : '') . number_format($variacao, 1, ',', '.') . '%'
                ];
            }

            return $meses;

        } catch(Exception $e) {
            error_log("Erro em getResumoMeses: " . $e->getMessage());
            return [];
        }
        finally{
            Banco::desconectar();
        }
    }

    // Método para obter serviços mais vendidos
    public function getServicosPopulares($periodo = 'mes') {
        $banco = Banco::conectar();
        
        try {
            switch($periodo) {
                case 'semana':
                    $dataInicio = "DATE_SUB(CURRENT_DATE, INTERVAL WEEKDAY(CURRENT_DATE) DAY)";
                    break;
                case 'mes':
                    $dataInicio = "DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')";
                    break;
                case 'trimestre':
                    $dataInicio = "DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)";
                    break;
                case 'ano':
                    $dataInicio = "DATE_SUB(CURRENT_DATE, INTERVAL 12 MONTH)";
                    break;
                default:
                    $dataInicio = "DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')";
            }

            $sql = "
                SELECT 
                    s.nome,
                    COUNT(*) AS quantidade,
                    SUM(s.valor) AS receita,
                    (COUNT(*) * 100.0 / (
                        SELECT COUNT(*) 
                        FROM agendamento a2
                        INNER JOIN calendario c2 ON a2.id_calendario = c2.id
                        WHERE c2.data >= $dataInicio
                          AND c2.data <= CURRENT_DATE
                          AND a2.status = 1
                    )) AS porcentagem
                FROM agendamento a
                INNER JOIN servicos s ON a.id_servico = s.id
                INNER JOIN calendario c ON a.id_calendario = c.id
                WHERE c.data >= $dataInicio
                  AND c.data <= CURRENT_DATE
                  AND a.status = 1
                GROUP BY s.id, s.nome
                ORDER BY quantidade DESC
                LIMIT 5
            ";
            
            $comando = $banco->prepare($sql);
            $comando->execute();
            $servicos = $comando->fetchAll(PDO::FETCH_ASSOC);

            return $servicos;

        } catch(Exception $e) {
            error_log("Erro em getServicosPopulares: " . $e->getMessage());
            return [];
        }
        finally{
            Banco::desconectar();
        }
    }

    // Método para obter o nome do período em português
    public function getNomePeriodo($periodo) {
        $nomes = [
            'semana' => 'Semanal',
            'mes' => 'Mensal',
            'trimestre' => 'Semestral',
            'ano' => 'Anual'
        ];
        return $nomes[$periodo] ?? 'Mensal';
    }
}

?>