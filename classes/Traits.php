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
                    if (!is_array($v)) {
                        die("run method expects an array");
                    }
                        $var = key($v);
                        $value = $v[$var];
                        switch($value) {
                            case "int":
                                $query->bindParam($k, $var, PDO::PARAM_INT);
                                break;
                            case "bool":
                                $query->bindParam($k, $var, PDO::PARAM_BOOL);
                                break;
                            case "str":
                            case "date":
                                $query->bindParam($k, $var, PDO::PARAM_STR);
                                break;
                            default:
                                die("No given or wrong datatype!");
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