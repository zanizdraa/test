<?php
/**
 * Class NewDateException
 */
class NewDateException extends Exception
{

}

/**
 * Interface NewDateInterface
 */
interface NewDateInterface
{
    /**
     * @param NewDateInterface $date2
     * @return mixed
     */
    public function diff(NewDateInterface $date2);
}

/**
 * Class NewDate
 */
class NewDate implements NewDateInterface
{

    /**
     * @var int $date , timestamp
     */
    protected  $date;

    /** Constructor
     * @param string $date  [optional]
     *
     * @return new NewDate instance
     *
     * @throws NewDateException  if Invalid date format
     */
    public function __construct($date = "now"){
        if(!$this->date = strtotime($date)){
            throw new NewDateException("Invalid date format");
        }
    }

    /** Calculates date difference between two dates
     *
     * @param NewDateInterface $date2
     *
     * @return object, date difference information
     *      stdClass Object
     *      (
     *          [total_days] => 720
     *          [invert] => false
     *          [years] => 1
     *          [months] => 11
     *          [days] => 20
     *      )
     */
    public function diff(NewDateInterface $date2){

        $result = array();

        $result["total_days"] = abs(floor(($this->date - $date2->date)/(3600*24)));
        $result['invert'] = ($this->date > $date2->date)?true:false;
        $minDate = min($this->date,$date2->date);
        $maxDate = max($this->date,$date2->date);

        $arr = array(
            "years" => "year",
            "months" => "month",
            "days" => "day"
        );
        foreach($arr as $key=> $value){
            $result[$key] = 0;
            while(strtotime("+1 $value", $minDate) <= $maxDate){
                $result[$key] = ($result[$key]+1);
                $minDate = strtotime("+1 $value", $minDate);
            }
        }
        return (object)$result;
    }
}
$dt2 = "2017-08-13";
$dt1 = "2010-01-23";

$date1 = new NewDate($dt1);
$date2 = new NewDate($dt2);

$res = $date1->diff($date2);

var_dump($res);die;
