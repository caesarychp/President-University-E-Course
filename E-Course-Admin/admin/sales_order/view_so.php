<style>
    :root {
        --primary-color: #1779ba;
        --secondary-color: #0b386f;
        --gray: #9b9b9b;
        --light-gray: #eeeeee;
        --medium-gray: #c8c3be;
        --dark-gray: #96918c;
        --black: #322d28;
        --white: #f3f3f3;
        --body-background: #ffffff;
        --body-font-color: var(--black);
    }

    body {
        font-family: 'Montserrat', sans-serif;
        font-weight: 400;
        color: var(--body-font-color);
    }

    header.top-bar h1 {
        font-family: 'Montserrat', sans-serif;
    }

    main {
        margin-top: 4rem;
        min-height: calc(100vh - 107px);
        margin-bottom: 0;
        /* Added to remove empty space */
    }

    main .inner-container {
        max-width: 800px;
        margin: 0 auto;
    }

    table.invoice {
        background: #fff;
    }

    table.invoice .num {
        font-weight: 200;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.8em;
    }

    table.invoice tr,
    table.invoice td {
        background: #fff;
        text-align: left;
        font-weight: 400;
        color: var(--body-font-color);
    }

    table.invoice tr.header td img {
        max-width: 300px;
    }

    table.invoice tr.header td h2 {
        text-align: right;
        font-family: 'Montserrat', sans-serif;
        font-weight: 200;
        font-size: 2rem;
        color: var(--primary-color);
    }

    table.invoice tr.intro td:nth-child(2) {
        text-align: right;
    }

    table.invoice tr.details>td {
        padding-top: 4rem;
        padding-bottom: 0;
    }

    table.invoice tr.details td.id,
    table.invoice tr.details td.qty {
        text-align: center;
    }

    table.invoice tr.details td:last-child,
    table.invoice tr.details th:last-child {
        text-align: right;
    }

    table.invoice tr.details table thead,
    table.invoice tr.details table tbody {
        position: relative;
    }

    table.invoice tr.details table thead:after,
    table.invoice tr.details table tbody:after {
        content: '';
        height: 1px;
        position: absolute;
        width: 100%;
        left: 0;
        margin-top: -1px;
        background: var(--medium-gray);
    }

    table.invoice tr.totals td {
        padding-top: 0;
    }

    table.invoice tr.totals td:nth-child(1) {
        font-weight: 500;
    }

    table.invoice tr.totals td:nth-child(2) {
        text-align: right;
        font-weight: 200;
    }

    table.invoice tr:nth-last-child(2) td:last-child:after {
        content: '';
        height: 4px;
        width: 110%;
        border-top: 1px solid var(--primary-color);
        border-bottom: 1px solid var(--primary-color);
        position: relative;
        right: 0;
        bottom: -0.575rem;
        display: block;
    }

    table.invoice tr.total td {
        font-size: 1.2em;
        padding-top: 0.5em;
        font-weight: 700;
    }

    table.invoice tr.total td:last-child {
        font-weight: 700;
    }

    .additional-info h5 {
        font-size: 0.8em;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--primary-color);
    }
</style>
<div class="row expanded">
    <main class="columns" style="margin: 0 auto;">
        <div class="inner-container">
            <header class="row align-center">
                <a class="button hollow secondary"><i class="ion ion-chevron-left"></i> Go Back to Purchases</a>
                &nbsp;&nbsp;<a class="button"><i class="ion ion-ios-printer-outline"></i> Print Invoice</a>
            </header>
            <section class="row">
                <div class="callout large invoice-container">
                    <table class="invoice">
                        <tr class="header">
                            <td class="">
                                <img src="http://www.travelerie.com/wp-content/uploads/2014/04/PlaceholderLogoBlue.jpg" alt="Company Name" />
                            </td>
                            <td class="align-right">
                                <h2>Invoice</h2>
                            </td>
                        </tr>
                        <tr class="intro">
                            <td class="">
                                Hello, Philip Brooks.<br>
                                Thank you for your order.
                            </td>
                            <td class="text-right">
                                <span class="num">Order #00302</span><br>
                                October 18, 2017
                            </td>
                        </tr>
                        <tr class="details">
                            <td colspan="2">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="desc">Item Description</th>
                                            <th class="id">Item ID</th>
                                            <th class="qty">Quantity</th>
                                            <th class="amt">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item">
                                            <td class="desc">Name or Description of item</td>
                                            <td class="id num">MH792AM</td>
                                            <td class="qty">1</td>
                                            <td class="amt">$100.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr class="totals">
                            <td></td>
                            <td>
                                <table>
                                    <tr class="subtotal">
                                        <td class="num">Subtotal</td>
                                        <td class="num">$100.00</td>
                                    </tr>
                                    <tr class="fees">
                                        <td class="num">Shipping & Handling</td>
                                        <td class="num">$0.00</td>
                                    </tr>
                                    <tr class="tax">
                                        <td class="num">Tax (7%)</td>
                                        <td class="num">$7.00</td>
                                    </tr>
                                    <tr class="total">
                                        <td>Total</td>
                                        <td>$107.00</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <section class="additional-info">
                        <div class="row">
                            <div class="columns">
                                <h5>Billing Information</h5>
                                <p>Philip Brooks<br>
                                    134 Madison Ave.<br>
                                    New York NY 00102<br>
                                    United States</p>
                            </div>
                            <div class="columns">
                                <h5>Payment Information</h5>
                                <p>Credit Card<br>
                                    Card Type: Visa<br>
                                    &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 1234
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </main>
</div>