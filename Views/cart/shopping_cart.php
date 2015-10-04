<div class="shopping-cart">
    <h2>Your Shopping Cart</h2>
    <?php
    if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0)
    {
        echo '<div class="cart-view-table-front" id="view-cart">';
        echo '<h3>Your Shopping Cart</h3>';
        echo '<form method="post" action="'. $model->baseUrl .'cart/update">';
        echo '<table width="100%"  cellpadding="6" cellspacing="0">';
        echo '<tbody>';

        $total =0;
        $b = 0;
        foreach ($_SESSION["cart_products"] as $cart_itm)
        {
            $product_name = $cart_itm["product_name"];
            $product_qty = $cart_itm["product_qty"];
            $product_price = $cart_itm["product_price"];
            $product_code = $cart_itm["product_code"];
            $bg_color = ($b++%2==1) ? 'odd' : 'even'; //zebra stripe
            echo '<tr class="'.$bg_color.'">';
            echo '<td>Qty <input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
            echo '<td>'.$product_name.'</td>';
            echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /> Remove</td>';
            echo '</tr>';
            $subtotal = ($product_price * $product_qty);
            $total = ($total + $subtotal);
        }
        echo '<td colspan="4">';
        echo '<button type="submit">Update</button><a href="'. $model->baseUrl .'cart/view" class="button">Checkout</a>';
        echo '</td>';
        echo '</tbody>';
        echo '</table>';

        $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
        echo '</form>';
        echo '</div>';

    }
    else {
        echo 'Empty for now..';
    }
    ?>
</div>