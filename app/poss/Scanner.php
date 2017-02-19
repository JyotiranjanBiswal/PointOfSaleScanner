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
 * Scanner the main file of scanning. Initiate the scanning process.
*/
class Scanner
{
	private $productInventory;

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->productInventory = new Inventory();
	}

	/**
	* Initialize inventory, listings, and terminal objects.
	*/
	public function startProcess()
	{
		// add products and prices here. 
		$this->productInventory->add("A", 2.00, array(4=>7.00));
		$this->productInventory->add("B", 12.00);
		$this->productInventory->add("C", 1.25, array(6=>6.00));
		$this->productInventory->add("D", 0.15);

		$productListing = new Listing($this->productInventory);
		$terminal = new Terminal($productListing);

		// process form data
		if (isset($_POST["submit"])) {
			$products = isset($_POST["product_txt"]) ? $_POST["product_txt"] : '';
			$products = str_replace(' ', '', $products);
			
			for ($i = 0; $i < strlen($products); $i++) {
				$_product = $products[$i];
				if ($_product != " ")
					$scannable = $terminal->scan($_product);

				// did the product go into the system?
				if (!$scannable && $_product != '')
					echo "Unable to get price for: " . $_product . "<br>";
			}
			if ($products != '' && strlen($products) > 0){
				echo "<b>The total cost of: " . $products . " is: $" . number_format($terminal->getTotalCost(), 2, '.', ',') . "</b>";
			} else {
				echo '<span class="error"><b>Please enter any product name to get price</b></span>';
			}
		}
	}
}
?>