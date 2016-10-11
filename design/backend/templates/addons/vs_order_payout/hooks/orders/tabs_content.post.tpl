<div id="content_payouts">
    <div class="control-group">
        <label class="control-label" for="payout_done">{__("payout_done")}:</label>
        <div class="controls">
            <input id="payout_done" class="input-small" type="checkbox" name="update_payout[payout_done]" value="Y" {if isset($update_payout.payout_done) and $update_payout.payout_done eq 'Y'} checked {/if} />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="elm_payout_date">{__("payout_date")}:</label>
        <div class="controls">
            {include file="common/calendar.tpl" date_id="elm_payout_date" date_name="update_payout[timestamp]" date_val=$update_payout.payout_date|default:$smarty.const.TIME start_year=$settings.Company.company_start_year}
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="payout_amount">{__("payout_amount")}:</label>
        <div class="controls">
            <input id="payout_amount" class="input-small" type="text" name="update_payout[payout_amount]" {if isset($update_payout.payout_amount)} value="{$update_payout.payout_amount}" {/if}/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="transaction_id">{__("transaction_id")}:</label>
        <div class="controls">
            <input id="transaction_id" class="input" type="text" name="update_payout[transaction_id]" {if isset($update_payout.transaction_id)} value="{$update_payout.transaction_id}" {/if}/>
        </div>
    </div>
</div>