<?php if ($model->error) {
?>
    <p><?= $model->error; ?></p>
<?php
}
else {
?>
    <div class="checkout">
        <form method="post" action="<?= $model->baseUrl; ?>cart/checkout_success">
            <p>The amount of your cart is: <?= $model->cart['totalAmount']; ?></p>
            <input type="hidden" name="total_amount" value="<?= $model->cart['totalAmount']; ?>" /><br />
            <br/>
            Delivery address:<br/>
            <input type="text" name="country" placeholder="Country.." /><br/>
            <input type="text" name="city" placeholder="City.." /><br/>
            <input type="text" name="street" placeholder="Street.." /><br/>
            Payment method:<br/>
            <input type="checkbox" name="payment" id="bank" value="bank"><label for="bank">Bank payment</label><br/>
            <input type="checkbox" name="payment" id="delivery" value="delivery"><label for="delivery">On delivery</label><br/>
            Contact phone:<br/>
            <input type="text" name="phone" placeholder="Phone.."/>
            <input type="submit" value="process"/>
        </form>
    </div>

<?php
}