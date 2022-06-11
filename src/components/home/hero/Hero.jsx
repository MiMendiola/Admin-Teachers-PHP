import React from "react"
import Heading from "../../common/heading/Heading"
import "./Hero.css"

const Hero = () => {
  return (
    <>
      <section className='hero'>
        <div className='container'>
          <div className='row'>
            <Heading subtitle='WELCOME TO VIRTUAL COMUNITY' title='Best Online Education Expertise' />
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, voluptatibus reiciendis vero ipsa velit non.</p>
            <div className='button'>
              <button className='primary-btn'>
                <a href="http://localhost/php/finalProyect2/">GET STARTED NOW</a> <i className='fa fa-long-arrow-alt-right'></i>
              </button>
              <button>
              <a href="http://localhost:3000/courses">VIEW COURSE</a> <i className='fa fa-long-arrow-alt-right'></i>
              </button>
            </div>
          </div>
        </div>
      </section>
      <div className='margin'></div>
    </>
  )
}

export default Hero
