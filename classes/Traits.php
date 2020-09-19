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
                $query = $this->prepare($sql);
                foreach ($values as $k => &$v) {
                    if (!is_array($v)) {
                        die("run method expects an array");
                    }
                        $var = key($v);
                        $data_type = $v[$var];
                        switch($data_type) {
                            case "int":
                                $query->bindValue($k, $var, PDO::PARAM_INT);
                                break;
                            case "bool":
                                $query->bindValue($k, $var, PDO::PARAM_BOOL);
                                break;
                            case "date":
                            case "str":
                                $query->bindValue($k, $var, PDO::PARAM_STR);
                                break;
                            case "null":
                                $query->bindValue($k, null, PDO::PARAM_INT);
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