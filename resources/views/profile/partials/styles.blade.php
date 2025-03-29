<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&display=swap');
    body {
        font-family: 'Cormorant Garamond', serif;
    }

    .center-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        flex-direction: column;
        min-height: calc(100vh - 5rem);
        padding: 2rem;
    }

    .tabs {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    button {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: bold;
    }

    .tab-active {
        background-color: rgb(13, 18, 40);
        color: white;
    }

    .tab-inactive {
        background-color: rgb(136, 154, 189);
        color: black;
    }

    .shadow-hover:hover {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    .form-input {
        width: 100%;
        padding: 12px;
        margin-top: 8px;
        border-radius: 8px;
        border: 1px solid #D1D5DB;
        transition: border-color 0.3s;
    }

    .form-input:focus {
        border-color: rgb(204, 214, 92);
        outline: none;
        box-shadow: 0 0 0 2px rgba(223, 227, 141, 0.5);
    }

    .profile-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .profile-header img {
        height: 8rem;
        width: 8rem;
        border-radius: 50%;
        margin: 0 auto;
        border: 4px solid rgb(207, 201, 136);
    }

    .profile-header h1 {
        margin-top: 1rem;
    }
</style>
