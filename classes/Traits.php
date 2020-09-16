<?php
trait basicPdoFunctions {
    private function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    private function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function run($sql, $values = []) {
        try {
            if (!empty($values)) {
                $query = $this->prepare($sql);
                $query->execute($values);
                return $query;
            }
            else {
                return $this->pdo->query($sql);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function getRow($sql, $values = []) {
        return $this->run($sql, $values)->fetch(PDO::FETCH_ASSOC);
    }

    public function getRows($sql, $values = []) {
        return $this->run($sql, $values)->fetchAll(PDO::FETCH_ASSOC);
    }
}