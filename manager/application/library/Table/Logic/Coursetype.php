<?php


class Table_Logic_Coursetype extends EloquentModel {
    protected $table = 't_course_type';

    public $timestamps = false;

    // public static $Type = [
    //     'base' => '基础',
    //     'characteristic' => '特色',
    //     'interest' => '兴趣',
    //     'level_examination' => '考级',
    // ];

    public static $Type = [
        [ 'id' =>'base',  'name' => '基础课'],
        [ 'id' =>'characteristic',  'name' => '特色课'],
        [ 'id' =>'interest',  'name' => '兴趣班'],
        [ 'id' =>'level_examination',  'name' => '考级班'],
    ];
}
