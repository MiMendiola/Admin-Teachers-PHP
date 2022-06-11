import React from "react"
import "./footer.css"

const Footer = () => {
  return (
    <>
      <footer>
        <div className='container padding'>
          <div className='box logo'>
            <h1>VIRTUAL COMUNITY</h1>
            <span>ONLINE EDUCATION & LEARNING</span>
            <p>Where you can find the best education. We aren't responsibles if you can't manage so many clients</p>

            <i className='fab fa-facebook-f icon'></i>
            <i className='fab fa-twitter icon'></i>
            <i className='fab fa-instagram icon'></i>
          </div>
          <div className='box link'>
            <h3>Explore</h3>
            <ul>
              <li><a href="http://localhost:3000/courses">Courses</a></li>
              <li><a href="http://localhost:3000/about">About Us</a></li>
              <li><a href="http://localhost:3000/team">Team</a></li>
              <li><a href="http://localhost:3000/beateacher">Join Us</a></li>
              <li><a href="http://localhost:3000/contact">Contact Us</a></li>
            </ul>
          </div>
          <div className='box link'>
            <h3>Quick Links</h3>
            <ul>
              <li><a href="http://localhost:3000/contact">Contact Us</a></li>
              <li>Terms & Conditions</li>
              <li>Privacy</li>
              <li>Feedbacks</li>
            </ul>
          </div>
          <div className='box link'>
            <h3>Join Us</h3>
            <ul>
              <li><a href="http://localhost:3000/beateacher">Join Us</a></li>
            </ul>
          </div>
          <div className='box last'>
            <h3>Have a Questions?</h3>
            <ul>
              <li>
                <i className='fa fa-map'></i>
                203 Fake St. Mountain View, San Francisco, California, USA
              </li>
              <li>
                <i className='fa fa-phone-alt'></i>
                +2 392 3929 210
              </li>
              <li>
                <i className='fa fa-paper-plane'></i>
                info@yourdomain.com
              </li>
            </ul>
          </div>
        </div>
      </footer>
      <div className='legal'>
        <p>
          Copyright ©2022 All rights reserved
        </p>
      </div>
    </>
  )
}

export default Footer
