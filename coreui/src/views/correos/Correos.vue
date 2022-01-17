<template>
  <CRow>
    <CCol col="12" xl="8">
      <transition name="slide">
      <CCard>
        <CCardBody>
           <h4>
              Gestión de Correos

            </h4>
            <!-- //lo esta haciendo en user -->
              <!-- <CButton color="primary" @click="createGanado()" class="mb-3">Añadir Ganado</CButton> -->
          <CAlert
            :show.sync="dismissCountDown"
            color="primary"
            fade
          >
            ({{dismissCountDown}}) {{ message }}
          </CAlert>
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
          <template #Ganado="{item}">
            <td>
              <CButton color="primary" @click="administrarGanado( item.id )">Enviar</CButton>
            </td>
          </template>
          
        </CDataTable>
        </CCardBody>
      </CCard>
      </transition>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Ganaderia',
  data: () => {
    return {
      items: [],
      fields: ['id', 'name', 'Ganado'],
      currentPage: 1,
      perPage: 5,
      totalRows: 0,
      you: null,
      message: '',
      showMessage: false,
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    }
  },
  paginationProps: {
    align: 'center',
    doubleArrows: false,
    previousButtonHtml: 'prev',
    nextButtonHtml: 'next'
  },
  methods: {
    getBadge (status) {
      return status === 'Active' ? 'success'
        : status === 'Inactive' ? 'secondary'
          : status === 'Pending' ? 'warning'
            : status === 'Banned' ? 'danger' : 'primary'
    },
    ganaderiaLink (id) {
      return `ganaderias/${id.toString()}`
    }, //no hace falta cuando valga ganado
    ganadoLink (id) {
      return `ganados/${id.toString()}`
    },
    editLink (id) {
      console.log('estoy en editlink')
      return `ganaderias/${id.toString()}/edit`
    },
    //crear las vistas vue
    showGanaderia ( id ) {
      const ganaderiaLink = this.ganaderiaLink( id );
      this.$router.push({path: ganaderiaLink});
    },//no haria falta cuando valga ganado

    administrarGanado ( id ){
        const ganadoLink = this.ganadoLink( id );
        this.$router.push({path: ganadoLink});
    },
    editGanaderia ( id ) {
      console.log('estoy en editGanaderia')
      const editLink = this.editLink( id );
      console.log(editLink);
      this.$router.push({path: editLink});
    },
    deleteGanaderia ( id ) {
      let self = this;
      let ganaderiaId = id;
      axios.post(  this.$apiAdress + '/api/ganaderias/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'DELETE'
      })
      .then(function (response) {
          self.message = 'Successfully deleted user.';
          self.showAlert();
          self.getGanaderias();
      }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
      });
    },
    createGanaderia () {
      this.$router.push({path: 'ganaderias/create'}); // corregido antes ponia solo create
    },
    
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
    getGanaderias (){
      let self = this;
      axios.get(  this.$apiAdress + '/api/ganaderias?token=' + localStorage.getItem("api_token"))
      .then(function (response) {
        self.items = response.data; //antes estaba data.ganaderia es solo data
                console.log("estpy aqui");
        self.you = response.data.you;
      }).catch(function (error) {
        console.log(error);
        console.log("estoy en el catch");
        // self.$router.push({ path: '/login' });
      });
    }
  },
  mounted: function(){
    this.getGanaderias();
  }
}
</script>
