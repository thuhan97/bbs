<style type="text/css">
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .datepicker {
        width: 100%;

    }

    body {
        /*font-size: 12px;*/
    }

    body.noScroll { /* ...or body.dialogShowing */
        overflow: hidden;
    }

    td {
        word-break: break-word;
    }

    .scrollbar {
        max-height: 500px;
        overflow-x: hidden;
        overflow-y: auto;
        min-width: 135px;
        margin-top: 0px;
        padding-left: 0px;
        padding-right: 2px;
    }

    @media screen and (max-width: 768px) {
        .admin-logo {
            width: 96px;
        }
    }

    @media screen and (max-width: 1024px) and (min-width: 768px) {
        .admin-logo {
            width: 40%;
        }
    }

    @media screen and (min-width: 1024px) {
        .admin-logo {
            width: 45%;
        }
    }

    .glyphicon-trash {
        font-size: 20px;
        cursor: pointer;
        padding: 10px;
    }

    .wrapper {
        overflow-y: hidden;
    }
</style>
