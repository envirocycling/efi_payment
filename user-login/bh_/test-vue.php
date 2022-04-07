<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>VUE 3 TEST 7</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- <link href="public/assets/vue-datepicker-next-1.0.2/index.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-datepicker-next@1.0.2/index.css">
</head>
<body>

<style>
    
</style>

<div id="app">
    <div class="container mt-4">

        <section>
            <p>format</p>
            <date-picker v-model="value1" value-type="DD/MM/YYYY" format="YYYY-MM-DD"></date-picker>
            <p>
              <code>v-model = {{ value1 }}</code>
            </p>
        </section>
        <section>
            <p>format</p>
            <date-picker v-model="value2" value-type="YYYY-MM-DD" format="DD/MM/YYYY"></date-picker>
            <p>
              <code>v-model = {{ value2 }}</code>
            </p>
        </section>
        
    </div>
</div>

<!-- <script src="public/assets/vue3/dist/vue.global.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/vue@3.2.26/dist/vue.global.js"></script>
<!-- <script src="public/assets/vue-datepicker-next-1.0.2/index.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/vue-datepicker-next@1.0.2/index.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

<script>
    var vm = Vue.createApp({
        components: {
            'date-picker':DatePicker,
        },
        data(){
            return {
                value1:'2019-10-09',
                value2:'2022-01-03',
            }
        },
    })
    .mount('#app')
</script>

</body>
</html>