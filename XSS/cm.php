@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    width: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background: #00b894;
}

.wrapper {
    padding: 20px;
    background: #FFF;
    box-shadow: 0 5px 10px rgba(0,0,0,0.3);
    width: 600px;
    min-height: 400px;
    margin: 20px 0;
}

.wrapper .row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
}

.wrapper .form .row .input-group {
    padding: 0 10px;
    display: block;
}

.wrapper .form .row .input-group:first-child {
    padding-left: 0;
}

.wrapper .form .row .input-group:last-child {
    padding-right: 0;
}

.wrapper .form .input-group {
    width: 100%;
    height: 50px;
    margin-bottom: 50px;
}

.wrapper .form .input-group label {
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
}

.wrapper .form .input-group .btn {
    margin: 20px 0;
    display: block;
    padding: .7rem 2rem;
    opacity: .8;
    color: #FFF;
    background: #00b894;
    border: none;
    outline: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 1rem;
    transition: .3s ease-in;
}

.wrapper .form .input-group .btn:hover {
    opacity: 1;
}

.wrapper .form .input-group input, .wrapper .form .input-group textarea {
    width: 100%;
    height: 100%;
    border: 1px solid #00b894;
    outline: none;
    padding: 5px 10px;
}

.wrapper .form .input-group.textarea {
    height: 200px;
}

.wrapper .form .input-group.textarea textarea {
    resize: none;
}

.wrapper .prev-comments {
    margin-top: 50px;
}

.wrapper .prev-comments .single-item {
    background: #FFF;
    box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    padding: 10px 20px;
    text-align: left;
    margin-bottom: 25px;
}

.wrapper .prev-comments .single-item h4 {
    font-size: 1.3rem;
    font-weight: 800;
    color: #111;
}

.wrapper .prev-comments .single-item a {
    margin: 10px 0;
    font-size: 1rem;
    color: #111;
    text-decoration: none;
    display: inline-block;
}

.wrapper .prev-comments .single-item p {
    font-size: .9rem;
    color: #111;
}