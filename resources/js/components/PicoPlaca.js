import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { baseUrl } from '../shared/baseUrl';
import { Card, Container, Row, Col, Form, Alert, Button, Modal, Spinner } from 'react-bootstrap';

export default class PicoPlaca extends Component {

    constructor(props) {
        super(props);
        this.state = {
            plateNumber: "",
            inputDate: "",
            inputTime: "",
            isLoading: false,
            validated: false,
            typeResult: "",
            messageResult: "",
            errorMessages: []
        }
        this.onChange = this.onChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    onChange(e) {
        this.setState({ [e.target.name]: e.target.value });
    }

    handleSubmit(event) {
        this.setState({
            typeResult: "",
            messageResult: "",
            errorMessages: [],
            validated: false
        });

        const form = event.currentTarget;

        if (form.checkValidity() === false) {
            event.stopPropagation();
            this.setState({ validated: true });
        } else {
            this.setState({ isLoading: true });
            this.submitForm();
        }

        event.preventDefault();
    }

    submitForm() {
        let token = document.head.querySelector('meta[name="csrf-token"]');

        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({
                '_token': token.content,
                'plateNumber': this.state.plateNumber,
                'inputDate': this.state.inputDate,
                'inputTime': this.state.inputTime
            })
        };

        fetch(baseUrl + 'predict', requestOptions)
            .then(async response => {
                const data = await response.json();

                this.setState({
                    isLoading: false,
                    typeResult: data.responseType,
                    messageResult: data.responseMessage
                });

                if (data.errors) {
                    console.log(data.errors);
                    this.setState({ errorMessages: data.errors })
                }

            })
            .catch(error => {
                console.error(error);
                this.setState({
                    isLoading: false,
                    typeResult: 'danger',
                    messageResult: error.toString()
                });
            });
    }

    render() {

        const checkboxStyle = {
            margin: '15px 0 0 0'
        };

        return (

            <Container fluid style={ checkboxStyle} >
                <Row>
                    <Col>
                        <Card >
                            <Card.Header className="text-center">
                                <h1>"Pico y Placa" Predictor.</h1>
                            </Card.Header>
                            <Card.Body>

                                {this.state.typeResult != "" ?
                                    <Alert variant={this.state.typeResult} >
                                        <Alert.Heading></Alert.Heading>
                                        <p>
                                            {this.state.messageResult}
                                        </p>
                                        {this.state.errorMessages.length > 0 ?
                                            <div>
                                                <p>Please check the following errors: </p>
                                                <ul>
                                                    {
                                                        this.state.errorMessages.map(function (item, i) {
                                                            return <li key={i} >{item}</li>
                                                        })
                                                    }
                                                </ul>
                                            </div>
                                            : null
                                        }
                                    </Alert> : null
                                }

                                <Form validated={this.state.validated} onSubmit={this.handleSubmit}>
                                    <Form.Group controlId="plateNumber">
                                        <Row>
                                            <Col sm="1"><Form.Label>Plate Number</Form.Label></Col>
                                            <Col sm="11">
                                                <Form.Control type="text" required name="plateNumber" value={this.state.plateNumber} onChange={this.onChange} placeholder="Enter your plate number." />
                                                <Form.Text>Example: PCW7369 </Form.Text>
                                                <Form.Control.Feedback type="invalid">
                                                    Not a valid plate number.
                                        </Form.Control.Feedback>
                                            </Col>
                                        </Row>
                                    </Form.Group>

                                    <Form.Group controlId="inputDate">
                                        <Row>
                                            <Col sm="1"><Form.Label>Date</Form.Label></Col>
                                            <Col sm="11">
                                                <Form.Control type="text" required name="inputDate" value={this.state.inputDate} onChange={this.onChange} />
                                                <Form.Text>Example: 2020-06-21 </Form.Text>
                                                <Form.Control.Feedback type="invalid">
                                                    Not a valid date.
                                        </Form.Control.Feedback>
                                            </Col>
                                        </Row>
                                    </Form.Group>

                                    <Form.Group controlId="inputTime">
                                        <Row>
                                            <Col sm="1"><Form.Label>Time</Form.Label></Col>
                                            <Col sm="11"><Form.Control type="text" required name="inputTime" value={this.state.inputTime} onChange={this.onChange} />
                                                <Form.Text>Example: 14:25 </Form.Text>
                                                <Form.Control.Feedback type="invalid">
                                                    Not a valid time.
                                        </Form.Control.Feedback>
                                            </Col>
                                        </Row>
                                    </Form.Group>

                                    <Row>
                                        <Col className="text-center">
                                            <Button size="lg" className="button nomargin text-center" type="submit" disabled={this.state.isLoading} >
                                                {this.state.isLoading ? 'Submitting..' : 'Submit'}
                                            </Button>
                                        </Col>
                                    </Row>
                                </Form>
                            </Card.Body>
                            <Card.Footer className="text-center">
                                Developed by <a href="https://github.com/albertinho88" target="_blank">albertinho88</a>.
                            </Card.Footer>
                        </Card>
                    </Col>
                </Row>
                <Modal id="modalLoading" size="sm" show={this.state.isLoading} centered  >
                    <div className="text-center" >
                        <Spinner animation="border" variant="light" />
                    </div>
                </Modal>
            </Container>
        );
    }
}

if (document.getElementById('picoplaca')) {
    ReactDOM.render(<PicoPlaca />, document.getElementById('picoplaca'));
}
