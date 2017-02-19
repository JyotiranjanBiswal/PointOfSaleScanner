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
 * An invoice system that tracks products and calculates the total
 * cost of all them based on a product listing. 	
 */
class Invoice
{
	private $invoice;
	private $productListing;

	/**
	* Constructor
	* @param Listing $productListing A Listing object.
	*/
	public function __construct($productListing)
	{
		$this->invoice = array();
		$this->productListing = $productListing;
	}

	/**
	* Adds the product to the invoice.
	* @param string $productName the product to be entered into the invoice.
	*/
	public function add($productName)
	{
		if ($this->isInInvoice($productName))
			$this->invoice[$productName]++;
		else
			$this->invoice[$productName] = 1;
	}

	/**
	* Calculates the total cost of all products tracked by the invoice.
	* @return float 
	*/
	public function getTotal()
	{
		$total = 0;

		foreach ($this->invoice as $productName => $productCount) {
			$total += $this->calculate($productName, $productCount);
		}

		return $total;
	}

	/**
	* Gets the number of products tracked by the invoice.
	* @return integer
	*/
	public function getCount()
	{
		return count($this->invoice);
	}

	/**
	* Removes all products in the invoice.
	*/
	public function clear()
	{
		$this->invoice = array();
	}

	/**
	* Checks if the product is tracked by the invoice.
	* @param string $productName the product to be checked.
	*/
	public function isInInvoice($productName)
	{
		return array_key_exists($productName, $this->invoice);
	}


	/*
	* This function will calculate the total cost of the product
	* based on the unit price and the volume prices of that product
	* given by the product listing.
	*
	* string $productName 
	* integer $productCount how many times product has this product been added? 
	*/
	private function calculate($productName, $productCount)
	{
		$volumePriceTotal = 0.00;

		// the remaining products to be calculated after the
		// volumes prices are calculated for that product.
		$remainder = $productCount;

		if ($this->productListing->hasVolumePrices($productName)) {
			// get volume price
			$productVolume = $this->productListing->getVolume($productName);
			$volumeCalculation = $this->calculateVolumePrice($productCount, $productVolume);

			$volumePriceTotal = $volumeCalculation[0];
			$remainder = $volumeCalculation[1];
		}

		// get unit prices
		$productUnitPrice = $this->productListing->getUnitPrice($productName);
		$unitPriceTotal = $this->calculateUnitPrice($remainder, $productUnitPrice);
		
		return $volumePriceTotal + $unitPriceTotal;
	}

	/*
	* Calculates volume price.
	* Return an array of the total volume price of the product and the remaining
	* product count.
	*/
	private function calculateVolumePrice($productCount, $productVolume)
	{
		$volumeCounts = array_keys($productVolume);

		$closestVolume = $this->findClosestVolume($productCount, $volumeCounts);
		$total = 0.00;

		while ($closestVolume != -1 && $productCount != 0) {
			if ($closestVolume > $productCount) {
				$closestVolume = $this->findClosestVolume($productCount, $volumeCounts);
			} else if (($productCount - $closestVolume) >= 0) {
				$productCount = $productCount - $closestVolume;
				$total += $productVolume[$closestVolume];
			}
		}

		return array($total, $productCount); 
	}	

	private function calculateUnitPrice($productCount, $unitPrice)
	{
		return $productCount * $unitPrice;
	}

	private function findClosestVolume($total, $volumes)
	{
		$smallest_diff = $total;
		$smallestVol = $volumes[0];

		foreach($volumes as $volume) {
			$diff = abs($total - $volume);

			if ($diff < $smallest_diff && $total >= $volume) {
				$smallest_diff = $diff;
				$smallestVol = $volume;
			}
		}

		if ($smallestVol > $total) // not found
			return -1;

		return $smallestVol;
	}
}
?>