<?php
interface CrudController {
    public function Insert($values);

    public function Delete($values);

    public function Update($values);
}