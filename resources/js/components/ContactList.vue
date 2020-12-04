<template>
    <div>
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-md-10">
                <div class="table-responsive-sm text-nowrap" v-if="dataTable">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Téléphone</th>
                                <th scope="col">Noms et prénoms</th>
                                <th scope="col" class="text-center" width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(contact, index) in this.contacts" :key="contact.id">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ contact.number }}</td>
                                <td>{{ contact.name }}</td>
                                <td>
                                    <button type="submit" @click="deleteContact(contact.id)" class="btn btn-sm btn-red white-text my-1">Supprimer</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10">
                <add-contact @contact-added="refresh"></add-contact>
            </div>
        </div>
        
    </div>
</template>

<script>
    // export default {

    //     data() {
    //         return {
    //             contacts: {},
    //             dataTable: false
    //         }
    //     },

    //     created() {
    //         axios.get("contacts")
    //         .then(response => {
    //             if (response.data.length > 0) {
    //                 this.dataTable = true
    //             }
    //             this.contacts = response.data
    //         })
    //         .catch(error => console.log(error));
    //     },

    //     methods: {
    //         refresh(contacts) {
    //             this.contacts = contacts.data
    //         },

    //         deleteContact(id) {
    //             axios.delete("contact/" + id + "/delete")
    //             .then(response => {
    //                 if (response.data.length > 0) {
    //                     this.dataTable = true
    //                 } else {
    //                     this.dataTable = false
    //                 }
    //                 this.contacts = response.data
    //             })
    //             .catch(error => console.log(error))
    //         }
    //     },

    //     mounted() {
    //         console.log('Component mounted.')
    //     }
    // }
</script>
