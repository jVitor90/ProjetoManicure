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
              AND agendamento.status = 0
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
          AND agendamento.status = 0
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
            error_log("Relatorio::fetFaturamentoSemanal erro: " . $e->getMessage());
            return "0,00";
            Banco::desconectar();
        }
    }

}


?>