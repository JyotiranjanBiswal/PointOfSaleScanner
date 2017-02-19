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
 * Listing will provide operations that will set and retrieve the
 * prices for product listed, as well as checking
 * if the product is avaliable in the inventory.
 */
class Listing
{
	private $productInventory;

	/**
	* Constructor
	* @param Inventory $productInventory
	*/
	public function __construct($productInventory)
	{
		$this->productInventory = $productInventory;
	}

	/**
	* Updates a product's unit price.
	* @param string $productName
	* @param float  $newUnitPrice
	*/
	public function updateUnitPrice($productName, $newUnitPrice)
	{
		if ($this->isProductAvaliable($productName)) {
			$product = $this->getProductFromInventory($productName);
			$product->setUnitPrice($newUnitPrice);
		}
	}

	/**
	* Updates a product's existing volume price. Adds new one if there no existing volume price.
	* @param string   $productName
	* @param integer  $volume          the volume unit
	* @param float    $newVolPrice   cost for that volume.
	*/
	public function updateVolumePrice($productName, $volume, $newVolPrice)
	{
		if ($this->isProductAvaliable($productName)) {
			$product = $this->getProductFromInventory($productName);
			$vol_price = $product->getVolumePrice($volume);

			$product->setVolumePrice($volume, $newVolPrice);
		}
	}

  	/**
	* Updates product's existing volume prices. Adds new ones if there no existing volume prices.
	* @param string   $productName
	* @param array    $volumes      key (integer) is the volume, value (float) is the cost.  
	*   
	*/
	public function updateVolumePrices($productName, $volumes)
	{
		if ($this->isProductAvaliable($productName)) {
			foreach ($volumes as $volume => $price) {
				$this->updateVolumePrice($productName, $volume, $price);
			}
		}
	}

  	/**
	* Removes product's existing volume price.
	* @param string   $productName
	* @param integer  $volume        the volume unit        
	*/
	public function removeVolumePrice($productName, $volume)
	{
		if ($this->isProductAvaliable($productName)) {
			$product = $this->getProductFromInventory($productName);
			$product->removeVolumePrice($volume);
		}
	}


  	/**
	* Gets product's unit price.
	* @param string  $productName
	*
	* @return float       
	*/
	public function getUnitPrice($productName)
	{
		if ($this->isProductAvaliable($productName)) {
			$product = $this->getProductFromInventory($productName);
			return $product->getUnitPrice();
		}
	}


  	/**
	* Gets product's volume price for a specific volume unit.
	* @param string  $productName
	* @param integer $volume        the volume unit 
	* 
	* @return float
	*/
	public function getVolumePrice($productName, $volume)
	{
		if ($this->isProductAvaliable($productName)) {
			$product = $this->getProductFromInventory($productName);
			
			return $product->getVolumePrice($volume);
		}
	}

	/**
	* Gets product's volume (volume unit and volume price).
	* @param string  $productName
	*
	* @return array
	*/
	public function getVolume($productName)
	{
		if ($this->isProductAvaliable($productName)) {
			$product = $this->getProductFromInventory($productName);
			return $product->getVolume();
		}
	}

	/**
	* Checks if a product has volume prices.
	* @param string  $productName
	*
	* @return boolean True if it does
	* @return boolean False if it does not
	*/
	public function hasVolumePrices($productName)
	{
		if ($this->isProductAvaliable($productName)) {
			$product = $this->getProductFromInventory($productName);
			$volume = $product->getVolume();
			if (!empty($volume))
				return true;
		}

		return False;
	}

	/**
	* Checks if a product exists.
	* @param string  $productName
	*
	* @return boolean True if it does
	* @return boolean False if it does not
	*/
	public function isProductAvaliable($productName)
	{
		$product = $this->getProductFromInventory($productName);

		return $product != null;
	}

	private function getProductFromInventory($productName)
	{
		return $this->productInventory->get($productName);
	}
}
?>