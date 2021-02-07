<?php

return [

    /*
     * The name of this application. You can use this name to monitor
     * the backups.
     */
    'name' => 'backup',

    /*
     * The database dump can be gzipped to decrease diskspace usage.
     */
    'compress' => 'zip', // zip | gz | gzip

    /*
     * download when dump
     */
    'download' => true,

    /*
     * delete after dump
     */
    'delete' => false,

    /*
     * The filename prefix used for the backup zip file.
     */
    'filename_prefix' => 'Myth_',

    /*
     * The disk names on which the backups will be stored.
     */
    'disks' => 'backup',
];
