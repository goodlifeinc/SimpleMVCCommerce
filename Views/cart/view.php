<?php if($model->error) {
?>
    <p><?= $model->error; ?></p>
<?php
}
else {
?>
    <div class="cart-view-table-back">
        <form method="post" id="viewCartForm">
            <table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantity</th><th>Name</th><th>Price</th><th>Total</th><th>Remove</th></tr></thead>
                <tbody>
                <?php
                if(isset($_SESSION["cart_products"])) //check session var
                {
                    $shipping_cost = 4;
                    $total = 0; //set initial total value
                    $b = 0; //var for zebra stripe table
                    foreach ($_SESSION["cart_products"] as $cart_itm)
                    {
                        //set variables to use in content below
                        $product_name = $cart_itm["product_name"];
                        $product_qty = $cart_itm["product_qty"];
                        $product_price = $cart_itm["product_price"];
                        $product_code = $cart_itm["product_code"];
                        $subtotal = ($product_price * $product_qty); //calculate Price x Qty

                        $bg_color = ($b++%2==1) ? 'odd' : 'even'; //class for zebra stripe
                        echo '<tr class="'.$bg_color.'">';
                        echo '<td><input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
                        echo '<td>'.$product_name.'</td>';
                        echo '<td>'.$product_price.'</td>';
                        echo '<td>'.$subtotal.'</td>';
                        echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /></td>';
                        echo '</tr>';
                        $total = ($total + $subtotal); //add subtotal to total var
                    }

                    $grand_total = $total + $shipping_cost; //grand total including shipping cost

                    $shipping_cost = ($shipping_cost)?'Shipping Cost : '. sprintf("%01.2f", $shipping_cost).'<br />':'';
                }
                ?>
                <tr><td colspan="5"><span style="float:right;text-align: right;"><?php echo $shipping_cost; ?>Amount Payable : <?php echo sprintf("%01.2f", $grand_total);?></span></td></tr>
                <tr><td colspan="5"><a href="index.php" class="button">Add More Items</a><button type="submit" name="update" id="update">Update</button><button type="submit" name="checkout" id="checkout">Checkout</button></td></tr>
                </tbody>
            </table>
            <input type="hidden" name="return_url" value="<?php
            $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            echo $current_url; ?>" />
            <input type="hidden" name="total_amount" value="<?=$grand_total; ?>" />
        </form>
    </div>
    <script>
        $('#update').click(function(){
            var form = document.getElementById("viewCartForm")
            form.action = "<?= $model->baseUrl; ?>cart/update";
            form.submit();
        });

        $('#checkout').click(function(){
            var form = document.getElementById("viewCartForm")
            form.action = "<?= $model->baseUrl; ?>cart/checkout";
            form.submit();
        });
    </script>

<?php
}
?>