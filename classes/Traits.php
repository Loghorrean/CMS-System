<?php
trait basicPdoFunctions {
    private function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    private function query($sql) {
        return $this->pdo->query($sql);
    }

    private function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    protected function run($sql, $values = []) {
        try {
            if (!empty($values)) {
                echo "<br>";
                $query = $this->prepare($sql);
                echo "<br>";
                foreach ($values as $k => &$v) {
                    if (is_array($v)) {
                        $key = key($v);
                        $value = $v[$key];
                        switch($value) {
                            case "int":
                                $query->bindParam($k, $key, PDO::PARAM_INT);
                                break;
                        }
                    }
                    else {
                        $query->bindParam($k, $v);
                    }
                }
                $query->execute();
                return $query;
            }
            else {
                return $this->query($sql);
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

    public function sql($sql, $values) {
        return $this->run($sql, $values);
    }
}