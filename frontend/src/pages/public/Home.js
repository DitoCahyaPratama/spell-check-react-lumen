import React, { useState } from 'react';
import { Button, Form, FormGroup, Label, Input, Col, Row, List } from 'reactstrap';
import { cekKata } from '../../utils/APIUtils';

const Home = (props) => {
	const [ kalimat, setKalimat ] = useState('');
	const [ responseMsg, setResponseMsg ] = useState({
		estimasi: 0,
		message: '',
		pembenaran: '',
		teksOri: '',
		totalKarakter: 0,
		totalKata: 0,
		totalSalah: 0,
        status: false,
	});

	const onSubmit = (e) => {
		e.preventDefault();
		cekKata(kalimat)
			.then((res) => {
				const data = res.data;
				setResponseMsg({
					estimasi: data.estimasi,
					message: data.message,
					pembenaran: data.pembenaran,
					teksOri: data.teksOri,
					totalKarakter: data.totalKarakter,
					totalKata: data.totalKata,
					totalSalah: data.totalSalah,
                    status: true
				});
			})
			.catch((err) => {
				console.log(err);
			});
	};

	return (
		<React.Fragment>
			<Form className="p-4" method="POST" onSubmit={(e) => onSubmit(e)}>
				<Row>
					<Col md="6">
						<FormGroup>
							<Label for="inputKalimat">Input Kalimat</Label>
							<Input
								type="textarea"
								name="kalimat"
								id="inputKalimat"
								onChange={(e) => setKalimat(e.target.value)}
							/>
						</FormGroup>
					</Col>
					<Col md="6">
						<FormGroup>
							<Label for="outputKalimat">Output Kalimat</Label>
							<div id="body">
								<div>
                                    {
                                        responseMsg.status ? (
                                            <div className="dt-hasil" dangerouslySetInnerHTML={{ __html: responseMsg.pembenaran }} />
                                        ) : (
                                            <Input
                                                type="textarea"
                                                name="outputKalimat"
                                                id="outputKalimat"
                                                onChange={(e) => setKalimat(e.target.value)}
                                            />
                                        )
                                    }
								</div>
							</div>
						</FormGroup>
					</Col>
				</Row>
				<Button>Submit</Button>
			</Form>
			<List className="p-4" type="unstyled">
				<li>
					Keterangan:
					<ul>
						<li>Estimasi: {responseMsg.estimasi}</li>
						<li>Total Karakter: {responseMsg.totalKarakter}</li>
						<li>Total Kata: {responseMsg.totalKata}</li>
						<li>Total Salah: {responseMsg.totalSalah}</li>
					</ul>
				</li>
			</List>
		</React.Fragment>
	);
};

export default Home;
