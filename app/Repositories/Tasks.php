<?php

namespace Taskr\Repositories;

use Taskr\Task;
use Illuminate\support\Facades\DB;

/**
 * Class Tasks is an repository which contains methods that combines
 * business log and data manipulation for Task objects. It also
 * avoids namespace clashes with eloquent methods that we are not
 * able to use.
 *
 * @package Taskr\Repositories
 */
class Tasks
{
    public function all()
    {
        $tasks = DB::select('select * from tasks');
        return $tasks;
    }

    public function belongsTo($id)
    {
        $tasks = DB::select('SELECT * FROM Tasks WHERE owner=?', [$id]);
        return $tasks;
    }

    public function delete($id) {
        DB::delete("DELETE FROM tasks WHERE id = ?", [$id]);
    }

    public function insert($title, $description, $category, $owner, $status, $start_date, $end_date) {
        DB::insert("INSERT INTO tasks (title, description, category, owner, status, start_date, end_date) values (?, ?, ?, ?, ?, ?, ?)",
            [$title, $description, $category, $owner, $status, $start_date, $end_date]);
    }

    public function update($id, $title, $description, $category, $start_date, $end_date) {
        DB::update("update tasks set title = ?, description = ?, category = ?, start_date = ?, end_date = ? where id = ?",
            [$title, $description, $category, $start_date, $end_date, $id]);
    }

    public function setStatus($id, $newStatus) {
        if ($newStatus == 0 || $newStatus == 1 || $newStatus == 2) {
            DB::update("update tasks set status = ? where id = ?", [$newStatus, $id]);
        }
    }
 
 }
