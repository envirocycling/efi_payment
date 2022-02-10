import MyTable from './components/x-table.js'
import MyModal from './components/x-modal.js'

Vue.createApp({
    components: {
        'date-picker':DatePicker,
        'x-table': MyTable,
        'x-modal': MyModal
    },
    data(){
        return {
            filters: {
                daterange: [new Date(), new Date()],
                bank: 'all',
                search: ''
            },
            bankOptions: {
                all: 'All Banks',
                sbc: 'Security Bank Corp',
                bdo: 'BDO Unibank INC',
                other: 'Other Bank'
            },
            payment: {},
            payments: [],
            showModal: false,
            isLoading: true
        }
    },
    methods: {
        async openModal(id) {

            const details = await fetch(`/efi_payment/api/get_payment_details.php?pid=${id}`)
            const result = await details.json()
            
            this.payment = result

            console.log(this.payment)
            this.showModal = true
        },
        async closeModal() {
            this.showModal = false
        },
        async fetchPayments() {
            try {
                const req = await fetch(`/efi_payment/api/get_pending_payments.php?from=2021/01/01&to=2021/07/30&bank=`)
                const payments = await req.json()
                this.isLoading = false
                this.payments = payments.data                
            } catch (error) {
                this.isLoading = false
                this.payments = []
                throw error
            }      
        },
        handleChangeDatePicker() {
            console.log(this.filters.daterange)
        },
        formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();
        
            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;
        
            return [year, month, day].join('-');
        }
    },
    computed: {

        formattedDateRange() {
            let start = this.filters.daterange[0]
            let end = this.filters.daterange[1]

            return `${this.formatDate(start)} ~ ${this.formatDate(end)}`;
        }

    },
    async created() {
        try {

            setTimeout( async () => {
                await this.fetchPayments();
            }, 3000)
            
        } catch (error) {}
    }
}).mount('#app')