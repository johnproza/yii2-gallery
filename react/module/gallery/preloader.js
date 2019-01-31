import React,{Component} from "react";

export default class Preloader extends Component {

    render() {
        return(
            <div className="row">
                <div className="col-md-12">
                    <div className="preloader2">
                        <div className="box1"></div>
                        <div className="box2"></div>
                        <div className="box3"></div>
                        <div className="box4"></div>
                    </div>
                </div>
            </div>
        )
    }
}