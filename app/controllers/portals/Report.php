<?php

/**
 * Report controller
 */

class Report
{
    use Controller;

    public function index()
    {
        $data = [];
        $this->view('Report', $data, __FUNCTION__);
    }

    public function merit($exam, $class)
    {
        $data = [];
        $appData = new App;
        $data = $appData->results_analysis($exam, $class, "meritListData");
        $this->view('Report', $data, __FUNCTION__);
    }

    public function merit_pdf($exam, $class)
    {
        $data = [];
        $data = ["exam" => $exam, "class" => $class];
        $this->view('Report', $data, __FUNCTION__);
    }

    public function report_forms($type, $exam, $class, $filter = "")
    {
        $data = [];
        $data = ["type" => $type, "exam" => $exam, "class" => $class, "filter" => $filter];
        $this->view('Report', $data, __FUNCTION__);
    }

    public function most_improved($exam, $class)
    {
        $data = [];
        $resRec = [];
        $appData = new App;
        $data['heading'] = "form " . $class . " most improved students";
        $resultsData = $appData->results_analysis($exam, $class, "meritListData");
        if (isset($resultsData['previousExam'])) {
            foreach ($resultsData['currentExam']['meritData'] as $currentKey => $current) {
                foreach ($resultsData['previousExam']['meritData'] as $previousKey => $previous) {
                    if ($currentKey == $previousKey) {
                        $deviation = $current['re_marks'] - $previous['re_marks'];
                        if ($deviation > 0) {
                            $resRec[] = array_merge($current, array("vap" => $deviation));
                        }
                    }
                }
            }
            // Final
            if (count($resRec) > 0) {
                array_multisort(array_column($resRec, 'vap'), SORT_DESC, $resRec);
                $data['mostImproved'] = $resRec;
            } else {
                $data['noRec'] = "No student recorded an improvement on this exam!";
            }
        } else {
            $data['noRec'] = "There is no previous exam records to determine Most Improved students!";
        }
        $this->view('Report', $data, __FUNCTION__);
    }

    public function trial_balance()
    {
        $data = [];
        $this->view('Report', $data, __FUNCTION__);
    }

    public function balance_sheet()
    {
        $data = [];
        $this->view('Report', $data, __FUNCTION__);
    }

    public function financial_statement()
    {
        $data = [];
        $this->view('Report', $data, __FUNCTION__);
    }
}
