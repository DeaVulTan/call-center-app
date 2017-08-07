<?php
class ExportToExcel
{
    protected $model;
    protected $header;

    const rowsPerPage = 1;

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    public function __construct($model = null, $header = null)
    {
        if (!empty($model)) {
            $this->setModel($model);
        }

        if (!empty($header)) {
            $this->setHeader($header);
        }
    }

    public function export()
    {
        if (empty($this->model)) {
            throw new Exception('Model is empty');
        }

        $headers = $this->model->getShow();
        $report = array();
        $row = array();
        foreach($headers as $header) {
            $row[] = $this->model->model()->getAttributeLabel($header);
        }
        $report[1] = $row;

        /** @var CActiveDataProvider $dp */
        $dp = $this->model->search();
        $dp->getPagination()->setPageSize(self::rowsPerPage);
        $totalRows = $dp->getTotalItemCount();
        $rowAdding = 0;
        while($rowAdding < $totalRows) {
            $models = $dp->getData();
            foreach($models as $val) {
                $row = array();
                foreach($headers as $head) {
                    $row[] = CHtml::value($val,$head);
                }
                $report[] = $row;
                $rowAdding++;
            }

            $nextPage = $dp->getPagination()->getCurrentPage() + 1;
            $dp = $this->model->search();
            $dp->getPagination()->setCurrentPage($nextPage);
            $dp->getPagination()->setPageSize(self::rowsPerPage);
        }

        Yii::import('application.extensions.phpexcel.JPhpExcel');
        $xls = new JPhpExcel('UTF-8', false, 'export');
        $xls->addArray($report);
        $xls->generateXML('export');
    }
}