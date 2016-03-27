<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Booking
 *
 * @author a7823
 */
class Timetable extends CI_Model{
    //put your code here
    protected $xml = null;
    protected $course = array();
    protected $dayofweek = array();
    protected $timeslot = array();
    
    function __construct() 
    {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH . 'lab7.xml');
        
        foreach($this->xml->dayofweek as $days)
        {
            $courses = array();
            foreach($days->class as $classes) 
            {
                $booking = new Booking();
                $booking->day = (string)$classes['day'];
                $booking->coursecode = (string)$classes['coursecode'];
                $booking->stime = (string)$classes['starttime'];
                $booking->etime = (string)$classes['endtime'];
                $booking->instructor = (string)$classes->instructor;
                $booking->type = (string)$classes->type['classtype'];
                $booking->room = (string)$classes->room;  
                $courses[(string)$booking->coursecode] = $booking;
            }
            $this->dayofweek[(string)$days['day']] = $courses;
        }
        
        foreach($this->xml->course as $course)
        {
            $courses = array();
            foreach($course->class as $classes) 
            {
                $booking = new Booking();
                $booking->day = (string)$classes['day'];
                $booking->coursecode = (string)$classes['coursecode'];
                $booking->stime = (string)$classes['starttime'];
                $booking->etime = (string)$classes['endtime'];
                $booking->instructor = (string)$classes->instructor;
                $booking->type = (string)$classes->type['classtype'];
                $booking->room = (string)$classes->room;  
                $courses[(string)$booking->coursecode] = $booking;
            }
            $this->course[(string)$course['coursecode']] = $courses;
        }
        
        foreach($this->xml->timeslot as $slots)
        {
            $courses = array();
            foreach($slots->class as $classes) 
            {
                $booking = new Booking();
                $booking->day = (string)$classes['day'];
                $booking->coursecode = (string)$classes['coursecode'];
                $booking->stime = (string)$classes['starttime'];
                $booking->etime = (string)$classes['endtime'];
                $booking->instructor = (string)$classes->instructor;
                $booking->type = (string)$classes->type['classtype'];
                $booking->room = (string)$classes->room;  
                $courses[(string)$booking->coursecode] = $booking;
            }
            $this->timeslot[(string)$slots['time']] = $courses;
        }
    }
    function geta()
    {
        return 'heyguys';
    }
    function getTimeslot()
    {
        return $this->timeslot;
    }
    
    function getCourse()
    {
        return $this->course;
    }
    
    function getDayofweek()
    {
        return $this->dayofweek;
    }
    
      function getDayKeys()
    {
        return array_keys($this->dayofweek);
    }

    
     function getCourseKeys()
    {
        return array_keys($this->course);
    }
    
     function getPeriodKeys()
    {
        return array_keys($this->timeslot);
    }
    
    function queryDay($day)
    {
      return $this->dayofweek[$day];
    }
    
    function queryCourse($course)
    {
      return $this->course[$course];
    }
    function queryTime($time)
    {
      return $this->timeslot[$time];
    }
    
    function query($day, $time, $course)
    {
        $result = array();
        $dayResult = array();
        $courseResult = array();
        $periodResult = array();
        if ($day !== "void")
        {
            $dayResult = $this->queryDay($day);
        }
        if ($time !== "void")
        {
            $periodResult = $this->queryTime($time);
        }
        if ($course !== "void")
        {
            $courseResult = $this->queryCourse($course);
        }
        array_push($result, $dayResult);
        array_push($result, $periodResult);
        array_push($result, $courseResult);
        return $result;
    }
}

class Booking
{
    public $coursecode;
    public $day;
    public $stime;
    public $etime;
    public $instructor;
    public $type;
    public $room;
}