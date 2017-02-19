<?php
/**
 * Point Of Sale Scanner
 * 
 * @package     Poss
 * @copyright   biswal@jyotiranjan.in 
 * @author      Jyotiranjan Biswal <biswal@jyotiranjan.in>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * INFORMATION
 *
 * The product class. Contains basic information about product such as name and prices.
*/
class Product
{
	private $name;
	private $unitPrice;
	private $volumePrices;

	public function __construct($productName, $unitPrice = 0.00, $volumePrices = array())
	{
		$this->name = $productName;
		$this->unitPrice = $unitPrice;
		$this->volumePrices = $volumePrices;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getVolumePrice($numberOfItems)
	{
		if (array_key_exists($numberOfItems , $this->volumePrices))
			return $this->volumePrices[$numberOfItems];
	}

	public function getVolume()
	{
		return $this->volumePrices;
	}

	public function setVolumePrice($numberOfItems, $price)
	{
		if ($numberOfItems > 1 && $price >= 0.00)
			$this->volumePrices[$numberOfItems] = $price;
	}

	public function removeVolumePrice($numberOfItems)
	{
		unset($this->volumePrices[$numberOfItems]);
	}

	public function getUnitPrice()
	{
		return $this->unitPrice;
	}

	public function setUnitPrice($price)
	{
		if ($price >= 0.00)
			$this->unitPrice = $price;
	}
}
?>