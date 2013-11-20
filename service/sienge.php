<?php
/**
 * undocumented class
 *
 * @package default
 * @author 
 */
class Sienge
{
	/**
	 * undocumented class variable
	 *
	 * @var string
	 */
	private $input;
	
	/**
	 * undocumented class variable
	 *
	 * @var string
	 */
	private $output;

    /**
     * undocumented function
     *
     * @param inputFacade $inputDB
     * @return void
     * @author
     */
	public function setInput(inputFacade $inputDB)
	{
        $this->input = $inputDB;
        return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 */
	public function setOutput(outputFacade $outputDB)
	{
        $this->output = $outputDB;
        return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 */
	public function startTransaction(relationMapper $dataMapper)
	{
	
    }

}

return new Sienge();