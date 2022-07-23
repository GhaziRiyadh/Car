<template>
    <div class=" h-[80vh] w-full overflow-auto shadow-xl sm:rounded-lg px-6">
        <!-- filter -->
        <div class="w-full border-b-2 h-1/5 flex items-center justify-between">
            <div class="flex items-center justify-around">

            </div>
            <div class="flex items-center justify-around text-sm">
                <div class="flex items-center mx-1">
                    <JetInput v-model="searchData" type="text" class="text-sm" :placeholder="`${isType.type}`"/>
                </div>
                <SecondaryButton class="mx-1" @click="getRecords(searchData, isType)">بحث</SecondaryButton>
                <PrimaryButton @click="showForm.add = true" class="mx-1">اضافة</PrimaryButton>
            </div>
        </div>

        <Users v-if="['USERS', 'USER'].includes(isType.type)" :get-data="showData.data" :addForm="showForm.add"
               :updateForm="showForm.update" :roles="showData.roles"
               @closeModel="showForm.update = false; showForm.add = false" :editData="editData"/>

        <Role v-if="isType.type === 'ROLE'" :getData="showData.data" :addForm="showForm.add"
              :updateForm="showForm.update" :roles="showData.roles"
              @closeModel="showForm.update = false; showForm.add = false"
              :editData="editData"/>
        <permission v-if="isType.type === 'PERMISSION'" :getData="showData.data" :addForm="showForm.add"
                    :updateForm="showForm.update" :roles="showData.roles"
                    @closeModel="showForm.update = false; showForm.add = false"
                    :editData="editData"/>
    </div>
</template>

<script>
import Users from '../components/users/users.vue'
import PrimaryButton from '../../Jetstream/PrimaryButton.vue'
import SecondaryButton from '../../Jetstream/SecondaryButton.vue'
import JetInput from '../../Jetstream/Input.vue'
import Role from '../components/users/role.vue'
import Permission from '../components/users/promission.vue'

export default {
    components: {
        Users,
        PrimaryButton,
        SecondaryButton,
        JetInput,
        Role,
        Permission
    },
    props: {
        getData: [],
        roles: [],
        type: {},
        getRecords: () => {
        },
    },
    watch: {
        type: function (nv, ov) {
            this.isType = nv
        },
        getData: function (nv, ov) {
            this.showData['data'] = nv
        },
        roles: function (nv, ov) {
            this.showData['roles'] = nv
        },
    },
    data() {
        return {
            searchData: '',
            showData: [],
            showForm: {
                add: false,
                update: false
            },
            showRoles: this.roles,
            isType: this.type,
            editData: {},
        }
    },
    created() {
        this.showData['data'] = this.getData
        this.showData['roles'] = this.roles
        console.log('user', this.showData)
    },
}
</script>

<style>
</style>
