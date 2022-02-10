
export default {
    props: ['payments', 'loading', 'openModal'],
    template: `
    <table id="" class="table table-bordered table-striped ">
        <thead>
            <tr>
                <th>Date Submitted</th>
                <th>Bank Code</th>
                <th>Voucher No.</th>
                <th>Supplier Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <tr v-if="loading"><td class="bold txt-center" colspan="7" style="padding: 30px 0;">Loading...</td></tr>
            <tr v-else v-for="payment in payments" :key="payment.payment_id">
                <td>{{payment.date}}</td>
                <td>{{payment.bank_code}}</td>
                <td>{{payment.voucher_no}}</td>
                <td>{{payment.supplier_name}}</td>
                <td>{{payment.grand_total}}</td>
                <td><label class="badge">Pending</label></td>
                <td><button class="btn btn-sm btn-success" @click="openModal(payment.payment_id)">View</button></td>
            </tr>
        </tbody>
    </table>
    `,
}
