<script setup>
import {ref} from 'vue'

import SideBarComponent from '../Layouts/SideBarComponent.vue';
import FooterComponent from './FooterComponent.vue';
import TobBarComponent from './TobBarComponent.vue';

const toggled = ref('')

const token = localStorage.getItem('access_token');


</script>

<template>
    <div id="wrapper">

    <!-- Sidebar -->
        <SideBarComponent v-if="token" :toggled="toggled"/>
    <!-- End of Sidebar -->

<!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
                <TobBarComponent v-if="token" @emitToggled="toggled=$event" />
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
<!--                <transition>-->
                    <router-view></router-view>
<!--                </transition>-->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <FooterComponent  ></FooterComponent>
        <!-- End of Footer -->

    </div>
<!-- End of Content Wrapper -->

</div>




</template>
