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
 * The point of scanner terminal. Scan products and get the total cost.
*/
class Terminal
{
	private $productListing;
	private $productInvoice;

	/**
	* Constructor
	* @param Listing $productListing A Listing object.
	*/
	public function __construct($productListing)
	{
		$this->productListing = $productListing;
		$this->productInvoice = new Invoice($this->productListing);
	}

	/**
	* Adds the product into the system.
	* @param string $productName the product's name to enter into system.
	*
	* @return boolean True if the system was able to add the product into the system, 
	* @return boolean False if the system wasn't able to add the product.			
	*
	* Note: If the terminal was unable to scan the product, make sure that
	* the product is listed first.
	*/
	public function scan($productName)
	{
		if ($this->productListing->isProductAvaliable($productName)) {
			$this->productInvoice->add($productName);
			return true;
		} 

		return False;
	}

	/**
	* Clears the products that were scanned in the system.
	*/
	public function reset()
	{
		$this->productInvoice->clear();
	}

	/**
	* Gets the total cost of the products scanned into the system.
	* 
	* Note: the terminal will still maintain the products scanned
	* after this method is called. To clear the terminal, call 
	* the reset() method.
	*/
	public function getTotalCost()
	{
		return $this->productInvoice->getTotal();
	}

	/**
	* Sets the unit prices for the product.
	* @param string $productName the product's name to change prices
	* @param float $unitPrice the unit price of the product.
	*/ 
	public function setUnitPricing($productName, $unitPrice)
	{
		$this->productListing->updateUnitPrice($productName, $unitPrice);
	}

	/**
	* Sets the volume prices for the product.
	* @param string $productName the product's name to change prices
	* @param array $volumePrices an array with the volume (integer) as key 
	* and volume price (float) as value. 
	*/
	public function setVolumePricing($productName, $volumePrices)
	{
		$this->productListing->updateVolumePrices($productName, $volumePrices);
	}
}
?>