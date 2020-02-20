<?php

/**
 * Class FirebirdInterface_FirebirdMapper
 */
class FirebirdInterface_FirebirdMapper {

    /**
     * @var PDO
     */
    public $pdo;

    /**
     * FirebirdInterface_FirebirdMapper constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * @param $fbprocedureName
     * @param $data
     * @param bool $findAll
     * @return mixed
     */
    public function execute($fbprocedureName, $data, $findAll = false) {

        $sth = $this->getSth($fbprocedureName, $data);

        if ($findAll) {
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $fbprocedureName
     * @param $data
     * @return mixed
     */
    private function getSth($fbprocedureName, $data) {
        if ($this->isAssoc($data)) {
            return $this->getSthWithParam($fbprocedureName, $data);
        } else {
            return $this->getSthWithoutParam($fbprocedureName, $data);
        }
    }

    /**
     * Проверяет ассоциативный ли массив
     * @param array $arr
     * @return bool
     */
    private function isAssoc(array $arr) {
        if (array() === $arr)
            return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Запрос для ассоциативный массива [':key' => value]
     * @param $fbprocedureName
     * @param $data
     * @return mixed
     */
    private function getSthWithParam($fbprocedureName, $data) {
        $fieldsName = implode(",", array_keys($data));
        return $this->pdo->dbExecute(
                        "select * from $fbprocedureName($fieldsName)", $data
        );
    }

    /**
     * Запрос для Не ассоциативного массива [value, value2]
     * @param $fbprocedureName
     * @param $data
     * @return mixed
     */
    private function getSthWithoutParam($fbprocedureName, $data) {
        $data = implode(",", array_keys($data));
        return $this->pdo->dbExecute(
                        "select * from $fbprocedureName($data)"
        );
    }

}
