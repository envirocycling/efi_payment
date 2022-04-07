export default {
  props: ['payment', 'modalTitle'],
  template: `
  <div class="v-modal-mask">
    <div class="v-modal">
                    
      <button class="btn btn-sm btn-danger v-modal__close_btn" @click="$emit('close')">x</button>

      <div class="v-modal__content">
        <div class="v-modal__header">
          <h3 class="txt-center">{{modalTitle}}</h3>
        </div>

        <div class="v-modal__body">
              <div class="row-details">
                  <div class="row-details__item">
                      <span class="bold">Date: </span> {{payment.date}}
                  </div>
                  <div class="row-details__item">
                      <span class="bold">Supplier: </span> {{payment.supplier}}
                  </div>
                  <div class="row-details__item">
                      <span class="bold">CV#: </span> {{payment.voucher}}
                  </div>
              </div>

              <div class="row-details mb-4">
                  <div class="row-details__item">
                      <span class="bold">Branch: </span> {{payment.branch}}
                  </div>
                  <div class="row-details__item">
                      <span class="bold">Account Name:</span> {{payment.account_name}}
                  </div>
                  <div class="row-details__item">
                      <span class="bold">Account Number: </span> {{payment.account_number}}
                  </div>
              </div>

              <h4>Delivery Breakdown</h4>


                <table class="txt-center" border="1" width="70%">
                    <thead>
                        <tr>
                            <th class="txt-center">WP Grade</th>
                            <th class="txt-center">Weight</th>
                            <th class="txt-center">Price</th>
                            <th class="txt-center">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr v-for="detail in payment.details" :key="detail.detail_id">
                        <td>{{detail.wp_grade}}</td>
                        <td>{{detail.net_weight}}</td>
                        <td>{{detail.price}}</td>
                        <td>{{detail.amount}}</td>
                      </tr>
                    </tbody>    
                </table>     


              <h4 class="txt-center">Sub Total: {{payment.sub_total}}</h4>

              <span>**************************************************************************************</span>

              <h4>Adjustments</h4>

              <table>
                  <tr>
                      <td><b>TS Fee:</b></td>
                      <td>-----------------------------------------</td>
                      <td align='right'>({{payment.ts_fee}})</td>
                  </tr>

                  <tr v-for="adjustment in payment.adjustments" :key="adjustment.adj_id">
                      <td><b>{{adjustment.desc}}</b></td>
                      <td>-----------------------------------------</td>
                      <td align='right' v-if="adjustment.adj_type == 'ADD'">{{adjustment.amount}}</td>
                      <td align='right' v-else>({{adjustment.amount}})</td>
                  </tr>
              </table>

              <h4>Grand Total: <span class="bold">{{payment.grand_total}}</span></h4>

              <span>-----------------------------------------------------------</span>

              <span>AP: {{payment.ap}}</span> 
              <span>Verifier: {{payment.verifier}}</span> 
              <span>Signatory: {{payment.signatory}}</span> 
          
        </div>

        <div class="v-modal__footer txt-center">
          <button type="button" class="btn btn-success">Approve</button>
          <button type="button" class="btn btn-danger">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  `
}


