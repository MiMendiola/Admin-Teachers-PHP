import React from "react"
import Back from "../common/back/Back"
import $ from "jquery";
import "./join.css"

const Joinus = () => {
  const createTeacherAccount = (ev) => {
    ev.preventDefault();
    let url = "https://finalproyect.com/"; //change this line and put the path for the other project

    $.ajax({
      type: "POST",
      url: url+"adminController/ajax_newTeacher",
      responseType: "json",
      data: {"name": $("#name").val(), "last_name": $("#last_name").val(), "passport": $("#passport").val(),"typeUser": 3, "email": $("#email").val(), "pass": $("#pass").val(), "code": $("#code").val() },
    }).then(res=>{
      res = JSON.parse(res);
      if(res.status == "ERROR"){
        alert('An error has occurred the user has not been inserted '+res.message);
      } else {
        alert('New User was created.');
      }
    })
  };
  return (
    <>
      <Back title='Be a teacher' />
      <section className='contacts padding'>
        <div className='container shadow'>
          <div className='right row'>
            <h1>Join us</h1>
            <p>We're waiting for you</p>

            <div className='items grid2'>
              <div className='box'>
                <h4>ADDRESS:</h4>
                <p>198 West 21th Street, Suite 721 New York NY 10016</p>
              </div>
              <div className='box'>
                <h4>EMAIL:</h4>
                <p> info@yoursite.com</p>
              </div>
              <div className='box'>
                <h4>PHONE:</h4>
                <p> + 1235 2355 98</p>
              </div>
            </div>

            <form action=''>
              <input type='text' name="code" id="code" placeholder='Code' />
              <div className='flexSB'>
                <input type='text' name="name" id="name" placeholder='Name' />
                <input type='text' name="last_name" id="last_name" placeholder='Last Name' />
              </div>
              <div className='flexSB'>
                <input type='text' name="passport" id="passport" placeholder='Passport' />
                <input type='email' name="email" id="email" placeholder='Email' />
              </div>
              <input type='password' name="pass" id="pass" placeholder='Password' />
              <button className='primary-btn' id='btn-newTeacher' onClick={(ev)=>createTeacherAccount(ev)}>BE ONE OF US</button>
            </form>

            <h3>Follow us here</h3>
            <span>FACEBOOK TWITTER INSTAGRAM DRIBBBLE</span>
          </div>
        </div>
      </section>
    </>
  )
}

export default Joinus
