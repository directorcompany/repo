<?php

namespace App\db\initial;

function initializeDb($db)
{
    //TODO: Create initial tables
    users($db);
    posts($db);
}

function posts($db) {
    $sql="CREATE TABLE posts (
        id INTEGER UNIQUE PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        body TEXT,
        creator_id INTEGER,
        created_at INTEGER,
        FOREIGN KEY (creator_id) REFERENCES users (id))"; 

    $db->query($sql);  
}

function users($db) {
    $sql="CREATE TABLE `users`(
        `id` INTEGER UNIQUE PRIMARY KEY AUTOINCREMENT,
        `email` TEXT,
        `first_name` TEXT,
        `last_name` TEXT,
        `password` TEXT,
        `created_at` INTEGER)";
    
    $db->query($sql);
}