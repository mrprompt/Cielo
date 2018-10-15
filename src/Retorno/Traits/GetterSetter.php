<?php
/**
 * Cielo
 *
 * Cliente para o Web Service da Cielo.
 *
 * O Web Service permite efetuar vendas com cartões de bandeira
 * VISA e Mastercard, tanto no débito quanto em compras a vista ou parceladas.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo\Retorno\Traits
 * @subpackage Serializer
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2013
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno\Traits;

trait GetterSetter 
{
	public function __call($method, $arguments)
	{
		$property = preg_replace('/^([s|g]et)/i', '', $method);

		if (!property_exists($this, $property)) {
			throw new \InvalidArgumentException('Invalid property');
		}

		if ($this->isSetter($method)) {
			$this->$property = array_shift($arguments);
		}

		if ($this->isGetter($method)) {
			return $this->$property;
		}
	}

	protected function isSetter($method)
	{
		return preg_match('/^(set)+/i', $method);
	}

	protected function isGetter($method)
	{
		return preg_match('/^(get)+/i', $method);
	}
}