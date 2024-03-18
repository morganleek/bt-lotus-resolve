<?php
	/**
	 * Uranium Price Block Template.
	 *
	 * @param   array $block The block settings and attributes.
	 * @param   string $content The block inner HTML (empty).
	 * @param   bool $is_preview True during backend preview render.
	 * @param   int $post_id The post ID the block is rendering content against.
	 *          This is either the post ID currently being displayed inside a query loop,
	 *          or the post ID of the post hosting this block.
	 * @param   array $context The context provided to the block by the post or it's parent block.
	 */

	// Support custom "anchor" values.
	$anchor = '';
	if ( ! empty( $block['anchor'] ) ) {
			$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
	}

	// Create class attribute allowing for custom "className" and "align" values.
	$class_name = 'uranium-price-block';
	if ( ! empty( $block['className'] ) ) {
		$class_name .= ' ' . $block['className'];
	}
	if ( ! empty( $block['align'] ) ) {
		$class_name .= ' align' . $block['align'];
	}

	$description = ( get_field( 'description' ) ) ?: '';
?>

<p <?php echo $anchor; ?> class="<?php echo esc_attr( $class_name ); ?> has-extra-small-font-size">
	<strong>
		<mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-lotus-green-color"><?php print $description; ?></mark>
		<span class="uranium-status"></span>
	</strong>
</p>

<script>
	if( typeof( numercoBidAsk ) !== "function" ) { // Only run once
		console.log( 'once' );
		function numercoBidAsk(){
			// Create our XMLHttpRequest object
			var hr = new XMLHttpRequest();
			// Create some variables we need to send to our PHP file
			var url = "https://numerco.com/api/kitco/kitco.php";
			var fn = "yXEjqTHFUeZNAc4sOcwBm"
			var ln = "vGiH3tb5XXOVidJ88XAa";
			var vars = "lgo="+fn+"&ynp="+ln;
			hr.open("POST", url, true);
			// Set content type header information for sending url encoded variables in the request
			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			// Access the onreadystatechange event for the XMLHttpRequest object
			hr.onreadystatechange = function() {
				if( hr.readyState == 4 && hr.status == 200 ) {
					var ab = JSON.parse(hr.responseText);
					const html = "<span class='price'><span class='currency'>US$</span><span class='amount'>" + parseFloat((ab.bid+ab.ask)/2).toFixed(2) + "</span></span> <span class='measures'>/LB U<sub>3</sub>O<sub>8</sub> (" + ab.change + "  " + ab.changeP + "%)</span>";

					document.querySelectorAll(".uranium-status").forEach( ( price ) => {
						// console.log( price );
						price.innerHTML = html;
					} );
				}
			}
			// Send the data to PHP now... and wait for response to update the uranium-status div
			hr.send( vars ); // Actually execute the request

			document.querySelectorAll(".uranium-status").forEach( ( price ) => {
				price.innerHTML = "Loading...";
				// price.className = "upload";
			} );
		}
		window.addEventListener( 'load', () => {
			numercoBidAsk();
		} );
	}
</script>
<!-- <script src="https://app.sharelinktechnologies.com/widget/js" defer></script> -->