<link rel="stylesheet" href="cbFilter/cbCss.css" />
<script src="cbFilter/jquery-1.8.3.js"></script>
<script src="cbFilter/jquery-ui.js"></script>
<style>

    #sup_picker{
        font-size:25px;
        width:500px;
    }
    .ui-combobox {
        position: relative;
        display: inline-block;
    }
    .ui-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
        /* adjust styles for IE 6/7 */
        *height: 1.7em;
        *top: 0.1em;
    }
    .ui-combobox-input {
        margin: 0;
        padding: 0.3em;
    }
</style>
<script>
    (function( $ ) {
        $.widget( "ui.combobox", {
            _create: function() {
                var input,
                that = this,
                select = this.element.hide(),
                selected = select.children( ":selected" ),
                value = selected.val() ? selected.text() : "",
                wrapper = this.wrapper = $( "<span>" )
                .addClass( "ui-combobox" )
                .insertAfter( select );

                function removeIfInvalid(element) {
                    var value = $( element ).val(),
                    matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
                    valid = false;
                    select.children( "option" ).each(function() {
                        if ( $( this ).text().match( matcher ) ) {
                            this.selected = valid = true;
                            return false;
                        }
                    });
                    if ( !valid ) {
                        // remove invalid value, as it didn't match anything
                        $( element )
                        .val( "" )
                        .attr( "title", value + " didn't match any item" )
                        .tooltip( "open" );
                        select.val( "" );
                        setTimeout(function() {
                            input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        input.data( "autocomplete" ).term = "";
                        return false;
                    }
                }

                input = $( "<input>" )
                .appendTo( wrapper )
                .val( value )
                .attr( "title", "" )
                .addClass( "ui-state-default ui-combobox-input" )
                .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: function( request, response ) {
                        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                        response( select.children( "option" ).map(function() {
                            var text = $( this ).text();
                            if ( this.value && ( !request.term || matcher.test(text) ) )
                                return {
                                    label: text.replace(
                                    new RegExp(
                                    "(?![^&;]+;)(?!<[^<>]*)(" +
                                        $.ui.autocomplete.escapeRegex(request.term) +
                                        ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                ), "<strong>$1</strong>" ),
                                    value: text,
                                    option: this
                                };
                        }) );
                    },
                    select: function( event, ui ) {
                        ui.item.option.selected = true;
                        that._trigger( "selected", event, {
                            item: ui.item.option
                        });
                    },
                    change: function( event, ui ) {
                        if ( !ui.item )
                            return removeIfInvalid( this );
                    }
                })
                .addClass( "ui-widget ui-widget-content ui-corner-left" );

                input.data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + item.label + "</a>" )
                    .appendTo( ul );
                };

                $( "<a>" )
                .attr( "tabIndex", -1 )
                .attr( "title", "Show All Items" )
                .tooltip()
                .appendTo( wrapper )
                .button({
                    icons: {
                        primary: "ui-icon-triangle-1-s"
                    },
                    text: false
                })
                .removeClass( "ui-corner-all" )
                .addClass( "ui-corner-right ui-combobox-toggle" )
                .click(function() {
                    // close if already visible
                    if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
                        input.autocomplete( "close" );
                        removeIfInvalid( input );
                        return;
                    }

                    // work around a bug (likely same cause as #5265)
                    $( this ).blur();

                    // pass empty string as value to search for, displaying all results
                    input.autocomplete( "search", "" );
                    input.focus();
                });

                input
                .tooltip({
                    position: {
                        of: this.button
                    },
                    tooltipClass: "ui-state-highlight"
                });
            },

            destroy: function() {
                this.wrapper.remove();
                this.element.show();
                $.Widget.prototype.destroy.call( this );
            }
        });
    })( jQuery );

    $(function() {
        $( "#combobox" ).combobox();
        $( "#toggle" ).click(function() {
            $( "#combobox" ).toggle();
        });
    });
</script>

<?php
$po_number=$_GET['po_number'];
include('configPhp.php');
$query="SELECT * FROM check_voucher where po_number=$po_number";
$result=mysql_query($query);
$row = mysql_fetch_array($result);
?>

<h2>Input Transfer Details </h2><hr>
<form action="record_transfer_details.php" method="POST">
    <?php
    echo "<input type='hidden' value='supplier_id' name='supplier_id' >";

    ?>
    <input type="hidden" value="<?php echo $po_number;?>" name="po_number">
    <table>
        <tr>
            <td> Reference Number:</td><td> <input type="text" value="" name="reference_number"></td>
        </tr>
        <tr>
            <td>Transferred From:</td><td> <input type="text" value="" name="transfer_from"></td>
        </tr>
        <tr>
            <td>Transferred To:</td>

            <td><select name="transfer_to" id="combobox" >

                    <?php
                    $query2="SELECT * FROM suppliers_account where supplier_id='".$row['supplier_id']."'";
                    $result2=mysql_query($query2);
                          echo "<option >123123123123(Supplier Name)</option>";

                    while( $row2 = mysql_fetch_array($result2)) {
                        echo "<option value='".$row2['acct_number']."'>(".$row2['bank'].")-".$row2['acct_number']."</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Amount:</td><td><input type="text" value="<?php echo $row['final_amount']; ?>" name="amount" readonly></td>
        </tr>

        <tr>
            <td>Remarks:</td><td> <input type="text" value="" name="remarks"></td>
        </tr>
        <tr>
            <td>Transaction Type:</td><td> <input type="text" value="" name="transaction_type"></td>
        </tr>
        <tr>
            <td>Transfer Date:</td> <td><input type="text" value="<?php echo date('Y/m/d'); ?>" name="transfer_date" readonly></td>
        </tr>
        <tr>
            <td></td><td><input type="submit" value="Submit"></td>
        </tr>
    </table>

</form>