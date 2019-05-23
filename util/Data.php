<?php
namespace fiscalizape\util;

class Data {
	private $segundos;
	private $minutos;
	private $horas;
	private $dias;
	private $meses;
	private $anos;
	private $agora;

	private function fusoRecife() {
		if (date_default_timezone_get() != 'America/Recife') {
			date_default_timezone_set('America/Recife');
		}
	}

	// Pega a diferença total entre duas datas
	public function intervaloParaAgora($intervalo, $data, $relativo = false) {
		// Setando fuso de recife e pegando data agora.
		$this->fusoRecife();
		$this->agora = new \DateTime();

		// Criando um DateTime com a data passada, caso seja uma string.
		if (is_string($data)) {
			$data = new \DateTime($data);
		}

		// Pegando diferença
		$diff = $data->diff($this->agora, !$relativo);

		// Pegando tempo total da diferença
		switch ($intervalo) {
			case 's':
				$total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
				break;

			case 'i':
				$total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
			break;

            case 'h':
				$total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
				break;

            case 'd':
				$total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
				break;

            case 'm':
				$total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
				break;

			case 'y':
				$total = $diff->y + $diff->m / 12 + $diff->d / 365.25;
				break;
		}

		if ($diff->invert) {
			return -1 * $total;
		}

		return (int)  $total;
	}

	public function intervaloPorExtenso($data) {
		$segundos = $this->intervaloParaAgora('s', $data);
		if ($segundos <= 59) {
			if ($segundos == 1) {
				return "$segundos segundo atrás";
			} else {
				return "$segundos segundos atrás";
			}
		} else {
			$minutos = $this->intervaloParaAgora('i', $data);
			if ($minutos <= 59) {
				if ($minutos == 1) {
					return "$minutos minuto atrás";
				} else {
					return "$minutos minutos atrás";
				}
			} else {
				$horas = $this->intervaloParaAgora('h', $data);
				if ($horas <= 23) {
					if ($horas == 1) {
						return "$horas hora atrás";
					} else {
						return "$horas horas atrás";
					}
				} else {
					$dias = $this->intervaloParaAgora('d', $data);
					$numDiasMes = date('t', strtotime($data));
					if ($dias <= $numDiasMes-1) {
						if ($dias == 1) {
						return "$dias dia atrás";
						} else {
							return "$dias dias atrás";
						}
					} else {
						$meses = $this->intervaloParaAgora('m', $data);
						if ($meses <= 11) {
							if ($meses == 1) {
								return "$meses mês atrás";
							} else {
								return "$meses meses atrás";
							}
						} else {
							$anos = $this->intervaloParaAgora('y', $data);
							if ($anos == 1) {
								return "$anos ano atrás";
							} else {
								return "$anos anos atrás";
							}
						}
					}
				}
			}
		}
	}
}