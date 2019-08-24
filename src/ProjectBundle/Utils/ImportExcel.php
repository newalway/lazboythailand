<?php

namespace ProjectBundle\Utils;

#use Liuggio\ExcelBundle\Factory;

use ProjectBundle\Utils\Collections;
use Symfony\Component\Translation\TranslatorInterface;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
// use PhpOffice\PhpSpreadsheet\Style\Conditional;
// use PhpOffice\PhpSpreadsheet\Style\Font;

// use PHPExcel_Style_Alignment;
// use PHPExcel_Style_Fill;
// use PHPExcel_Style_Color;
// use PHPExcel_IOFactory;
// use PHPExcel_Shared_Date;

class ImportExcel
{
	private $kernel;
	private $index;
	private $spreadsheet;
	private $translator;

	#protected $phpexcel;
	#protected $phpExcelObject;

	public function __construct($kernel, TranslatorInterface $translator)
	{
		$this->container = $kernel->getContainer();
		$this->spreadsheet = new Spreadsheet();
		$this->index = 0;
		$this->translator = $translator;

		#$this->phpexcel = $phpexcel;
		#$this->phpExcelObject = $this->phpexcel->createPHPExcelObject();
		#$this->index = 0;
	}

	public function importExcelFile($file)
	{
		$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);

		$isValid = false;
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		if ($reader->canRead($file)) {
			$isValid = true;
		}

		if ($isValid) {
			// e.g. PHPExcel_IOFactory::load($file_path)
			// Tosses exception
			//$reader = PHPExcel_IOFactory::createReaderForFile($file);

			// Need this otherwise dates and such are returned formatted
			/** @noinspection PhpUndefinedMethodInspection */
			$reader->setReadDataOnly(true);

			//$reader->enableMemoryOptimization(); //Call to undefined method

			// Just grab all the rows
			$spreadsheet = $reader->load($file);
			// $worksheet = $spreadsheet->getActiveSheet();
			$worksheet = $spreadsheet->getSheet(0);

			// $worksheet = $spreadsheet->getSheet(0);
			// $rows = $worksheet->toArray();

			return $worksheet;
		}else {
			return $isValid;
		}

	}

	public function excelDateFormat($date)
	{
		//excel send $date is a unix date format
		$newdate = (new \DateTime())->format('Y-m-d H:i:s');

		if(!empty($date)){
			if(\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($date)){
				echo 'date format';
				exit;
				$newdate = date('Y-m-d H:i:s', PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($date));
			}
		}

		return $newdate;
	}

	public function validateRow($rowArr)
	{
		if(is_null($rowArr)){

		}
		return $rowArr;
	}


}
