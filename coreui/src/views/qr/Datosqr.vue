<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <div :style="titulo" class="titulo">Ganaderia id:  {{ $route.params.id }}</div>
          <CButton color="primary" @click="createGanado($route.params.id)" class="mb-3">Añadir Ganado</CButton>
          <!-- arriba he mandado el id de ganderia para intentar hacer como un edit -->
        <CDataTable
            hover
            striped
            :items="items"
            :fields="fields"
            :items-per-page="5"
            pagination
          >
          <template #status="{item}">
            <td>
              <CBadge :color="getBadge(item.status)">{{ item.status }}</CBadge>
            </td>
          </template>
          <!-- <template #show="{item}">
            <td>
              <CButton color="primary" @click="showGanado( item.id )">Mostrar</CButton>
            </td>
          </template> -->
          <template #diagnosticar="{item}">
            <td>
              <CButton color="primary" @click="diagnosticarGanado( item.id )">Diagnosticar</CButton>
            </td>
          </template>
           <template #gestionar="{item}">
            <td>
              <CButton color="primary" @click="gestiondiagnostico( item.id )">Diagnosticos</CButton>
            </td>
          </template>
           <template #QR="{item}">
            <td>
              <CButton color="primary" @click="obtenerqr( item.id )">Obtener QR</CButton>
            </td>
          </template>
          <template #edit="{item}">
            <td>
              <CButton color="primary" @click="editGanado( item.id )">Editar</CButton>
            </td>
          </template>
          <template #delete="{item}">
            <td>
              <CButton v-if="you!=item.id" color="danger" @click="deleteGanado( item.id )">Eliminar</CButton>
            </td>
          </template>
        </CDataTable>
        <CButton color="primary" @click="goBack">Volver</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Ganados',
  /*
  props: {
    caption: {
      type: String,
      default: 'User id'
    },
  },
  */
  data: () => {
    return {
      items: [],
      fields: ['id','name', 'crotal', 'diagnosticar', 'gestionar','QR','edit', 'delete'],  
      name: '',
      crotal:'',
      
    }
  },
  paginationProps: {
    align: 'center',
    doubleArrows: false,
    previousButtonHtml: 'prev',
    nextButtonHtml: 'next'
  },
  methods: {
    goBack() {
      this.$router.go(-1)
    },
    ganadoLink (id) {
      return `${id.toString()}`
    },
    showGanado ( id ) {
      const ganadoLink = this.ganadoLink( id );
      this.$router.push({path: ganadoLink});
    },
    editLink (id) {
      console.log('estoy en editlink')
      return `${id.toString()}/edit`
    },
    createLink (id){
      return`${id.toString()}/create`
    },
    creatediagnosticarLink (id){
      return `${id.toString()}/creatediagnostico`
    },
    gestiondiagnosticoLink (id){
      return `${id.toString()}/diagnosticos`
    },
    qrLink (id){
      return `${id.toString()}/qrs`
    },
    editGanado ( id ) {
      console.log('estoy en editGanaderia de ganado')
      const editLink = this.editLink( id );
      console.log(editLink);
      this.$router.push({path: editLink});
    },
    diagnosticarGanado ( id ) {
      // const editLink = this.editLink( id );
      // console.log(editLink);
      // this.$router.push({path: editLink});
      const createLink = this.creatediagnosticarLink( id );
      this.$router.push({path: createLink});
    },
    gestiondiagnostico (id){
      const createLink = this.gestiondiagnosticoLink( id );
      this.$router.push({path: createLink});
    },
     obtenerqr (id){
      const createLink = this.qrLink( id );
      this.$router.push({path: createLink});
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
    deleteGanado ( id ) {
      let self = this;
      let ganadoId = id;
      axios.post(  this.$apiAdress + '/api/ganados/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'DELETE'
      })
      .then(function (response) {
          self.message = 'Successfully deleted user.';
          self.showAlert();
          self.getGanado();
      }).catch(function (error) {
        console.log(error);
        // self.$router.push({ path: '/login' });
      });
    },
      createGanado (id) {
      const createLink = this.createLink( id );
      this.$router.push({path: createLink});
      // this.$router.push({path: 'create'}); // corregido antes ponia solo create
    },
    
    getGanado(){
      let self = this;
      axios.get(  this.$apiAdress + '/api/ganados/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"))
      .then(function (response) {
        self.items = response.data;
        console.log(self.data);
        self.you = response.data.you;
    }).catch(function (error) {
      console.log(error);
    //   self.$router.push({ path: '/login' })
    });
    }
  },
  mounted: function(){
    this.getGanado();
    // let self = this;
    // axios.get(  this.$apiAdress + '/api/ganados/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"))
    // .then(function (response) {
    //   self.items = response.data;
    //   console.log(self.data);
    //   self.you = response.data.you;
    // }).catch(function (error) {
    //   console.log(error);
    //   self.$router.push({ path: '/login' })
    //});
  }
}


</script>
<style>
    .titulo {
        
        text-align: left; 
        font-family: Arial Black; 
        font-weight: bold; 
        font-size: 30px; 
        color: #fff; 
        text-shadow: -1px 0 #000, 0 1px #000, 1px 0 #000, 0 -1px #000;
}
    
</style>
