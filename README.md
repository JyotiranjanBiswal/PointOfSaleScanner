Consider a store where items have prices per unit but also volume prices. For example, apples may be $1.00 each or 4 for $3.00.
Implement a point-of-sale scanning API that accepts an arbitrary ordering of products (similar to what would happen at a checkout line)
and then returns the correct total price for an entire shopping cart based on the per unit prices or the volume prices as applicable.
<h3>Here are the products listed by code and the prices to use (there is no sales tax):</h3>
<table>
	<tbody>
		<tr>
			<th>Product Code</th>
			<th>Price</th>
		</tr>
		<tr>
			<td>A</td>
			<td>$2.00 each or 4 for $7.00</td>
		</tr>
		<tr>
			<td>B</td>
			<td>$12.00</td>
		</tr>
			<td>C</td>
			<td>$1.25 or $6 for a six pack</td>
		</tr>
		</tr>
			<td>D</td>
			<td>$0.15</td>
		</tr>
	</tbody>
</table>

There should be a top level point of sale terminal service object that looks something like the pseudo-code below. You are free to
design and implement the rest of the code however you wish, including how you specify the prices in the system:
```
terminal->setPricing(...)
terminal->scan("A")
terminal->scan("C")
... etc.
result = terminal->total
```
<h3>Here are the minimal inputs you should use for your test cases. These test cases must be shown to work in your program: </h3>

```
Scan these items in this order: ABCDABAA; Verify the total price is $32.40.
Scan these items in this order: CCCCCCC; Verify the total price is $7.25.
Scan these items in this order: ABCD; Verify the total price is $15.40.
```
