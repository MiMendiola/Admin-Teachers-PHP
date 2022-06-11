import React from "react"
import Back from "../common/back/Back"
import "./join.css"

const Joinus = () => {
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
              <button className='primary-btn'>BE ONE OF US</button>
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
