
<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <h3>Ganaderia id:  {{ $route.params.id }}</h3>

          <h4>
            Nombre de la Ganaderia: {{ name }}
          </h4>
          <h4>
            Crotal: {{ crotal }}
          </h4>
          <h4>
            Costillar: {{ costillar }}
          </h4>
          <h4>
            Raza: {{ raza }}
          </h4>
          <h4>
            Código QR: 
            <br>
            <qrcode :value="qr" :options="{ color: { dark: '#0275d8' } }"></qrcode>
            <!-- <qrcode value="http://192.168.1.34:8080/#/ganados/" :options="{ color: { dark: '#0275d8' } }"></qrcode> -->
          </h4>
         
        <br>
          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
    import axios from 'axios'
    import Qrcode from '@chenfengyuan/vue-qrcode';

    export default {
      name: 'Ganados',
      components: {
        Qrcode
      },
      data(){
        return {
          // options: 'http://192.168.1.34:8080/#/ganados/',
          // qr:'http://192.168.1.34:8080/#/ganados/2/qrs',
          qr:'',
          name:'',
          crotal:'',
          costillar:'',
          raza:'',
          ganaderia_id:'' 
        }
      
      },
      methods: {
        goBack() {
          this.$router.go(-1)
        }
      },
      mounted: function(){
        let self = this;
        axios.get(  this.$apiAdress + '/api/ganados/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
        .then(function (response) {
          console.log("estoy en el then de ganados");
          self.name = response.data.name
          self.crotal = response.data.crotal
          self.costillar = response.data.costillar
          self.raza = response.data.raza
          self.qr = 'http://192.168.1.34:8080/#/ganados/'+ self.$route.params.id + '/qrs'
          console.log(self.name);
        }).catch(function (error) {
          console.log(error);
          // self.$router.push({ path: '/login' })
      });
  }
    }
</script>