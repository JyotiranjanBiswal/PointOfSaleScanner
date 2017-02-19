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
 * Inventory manages products, including adding and removing products.
 */
class Inventory
{
	private $inventory;

	public function __construct()
	{
		$this->inventory = array();
	}

	/**
	* Add product to the inventory.
	* @param string $productName
	* @param float $unitPrice     the unit price of the product 
	* @param array $volPrices     the volume prices of the product
	*
	* @throws Exception if either $unitPrice or $volPrices's values are not numbers.
	*/
	public function add($productName, $unitPrice=0.00, $volPrices=array())
	{
		try {
			$this->checkVolumePricesAreValid($volPrices);
			$this->checkUnitPriceIsValid($unitPrice);

			if (!$this->isInInventory($productName))
				$this->inventory[$productName] = new Product($productName, $unitPrice, $volPrices);
		} catch (Exception $e) {
			echo nl2br($e->getMessage() . " for Product <b>" . $productName. "</b>\n");
			echo nl2br("Product <b>" . $productName . "</b> has not been added to the system\n");
		}
	}

	private function checkVolumePricesAreValid($volPrices)
	{
		foreach($volPrices as $key=>$value) {
			if (!is_numeric($value) || !is_numeric($key))
				throw new Exception("Cannot process volume: <b>" . $key . "," .$value . "</b>");
		}
	}

	private function checkUnitPriceIsValid($unitPrice)
	{
		if (!is_numeric($unitPrice)) {
			throw new Exception("Cannot process unit price: <b>" . $unitPrice . "</b>");
		}
	}
	/**
	* Retrieves product from the inventory.
	* @param string $productName
	*
	* @return Product
	*/
	public function get($productName)
	{
		if ($this->isInInventory($productName))
			return $this->inventory[$productName]; 
	}

	/**
	* Removes product from the inventory.
	* 
	* @param string $productName
	*/
	public function remove($productName)
	{
		unset($this->inventory[$productName]);
	}

	/**
	* Checks if product is in the inventory.
	* 
	* @param string $productName
	*
	* @return boolean
	*/
	public function isInInventory($productName)
	{
		return array_key_exists($productName, $this->inventory);
	}
}
?>