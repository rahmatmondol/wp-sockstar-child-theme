<style>
    /* html input range styling */

    /* default */
    input[type='range'] {
        width: 100%;
    }

    /* plugin theme  */

    .socks-calculator-range-container {
        position: relative;
        height: 15px;
        margin-bottom: 20px;
        /* Added margin between sliders */
    }

    .socks-calculator-range-container input[type='range'] {
        -webkit-appearance: none;
        height: 6px;
        margin: 0;
        background: #ade8e5;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.24);
        border-radius: 2px;
        outline: none;
        cursor: pointer;
    }

    .socks-calculator-range-container input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 35px;
        height: 35px;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.24);
        background-image: linear-gradient(to bottom, #1ba39c 0, #3AAFA9 100%);
        border-radius: 50%;
        position: relative;
        z-index: 1;
    }


    .socks-calculator-range-container .hir-tracker-bg,
    .socks-calculator-range-container .hir-tracker-bg::after,
    .socks-calculator-range-container .hir-tracker-bg::before {
        position: absolute;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.24);
    }

    .socks-calculator-range-container .hir-tracker-bg {
        top: 12px;
        width: calc(100%);
        height: 6px;
        background-color: #ade8e5;
        border-radius: 5px;
    }

    .socks-calculator-range-container .hir-tracker-thumb,
    .socks-calculator-range-container .hir-tracker-thumb::after {
        position: absolute;
        background-color: #3AAFA9;
    }

    .socks-calculator-range-container .hir-tracker-thumb {
        top: 12px;
        left: 0;
        height: 6px;
        /* transition: width 150ms linear; */
        border-radius: 2px;
    }

    .socks-calculator-range-container .socks-tooltip,
    .socks-calculator-range-container .socks-tooltip::after,
    .socks-calculator-range-container .socks-tooltip::before {
        position: absolute;
    }

    .socks-calculator-range-container .socks-tooltip {
        z-index: 3;
        top: -90px;
        left: 50%;
        /* Centered socks-tooltip */
        padding: 5px;
        transform: translateX(-50%);
        font-size: 14px;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.24);
        transition: left 100ms linear;
        min-width: 140px;
        background-color: #fff;
    }

    .socks-calculator-range-container .socks-tooltip::after,
    .socks-calculator-range-container .socks-tooltip::before {
        content: '';
        width: 0;
        height: 0;
    }

    .socks-calculator-range-container .socks-tooltip::after {
        bottom: -8px;
        left: calc(50% - 4px);
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-top: 8px solid #fff;
    }

    .socks-calculator-range-container .socks-tooltip::before {
        bottom: -7px;
        left: calc(50% - 5px);
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-top: 8px solid #f1f1f1;
    }

    .socks-calculator-range-container .socks-tooltip p {
        /* text-transform: capitalize; */
    }

    .socks-calculator-range-container .hir-labels {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    /* helper styles */

    input[type='range']+p {
        font-size: 12px;
        color: #666;
    }

    .calculator-container {
        margin-bottom: 40px;
    }


    .calculator-container {
        margin-bottom: 40px;
    }

    .profit-calculator-result {
        margin-top: 80px;
        padding: 10px;
        /* background-color: #3498db; */
        color: #000;
        text-align: center;
    }

    .profit-calculator-result p {
        font-size: 60px;
    }

    .profit-calculator-result h4 {
        text-transform: uppercase;
    }
</style>
<div class="row">
    <div class="col-md-6 col-12">
        <div class="socks-calculator-range-container">
            <input type="range" class="socks-calculator-range" id="productRange" value="25" data-tooltip-text="<?php echo __('Person who sells', 'hello-elementor'); ?>">
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="socks-calculator-range-container">
            <input type="range" class="socks-calculator-range" id="orderRange" value="12" data-tooltip-text="<?php echo __('Product each', 'hello-elementor'); ?>">
        </div>
    </div>
</div>

<div class="profit-calculator-result">
    <h4><?php echo __('Your Profit', 'hello-elementor'); ?></h4>
    <p data-currency="SEK">0.00</p>
</div>