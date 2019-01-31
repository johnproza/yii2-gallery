import React,{Component} from "react";

export default class Message extends Component {

    constructor(props) {
        super(props);
        this.state = {
            message : this.props.text,
            delay:5000
        }
    }

    render() {
        return (
            <div className="messageComment">
                {this.state.message}
            </div>
        )
    }


}