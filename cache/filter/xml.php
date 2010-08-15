<?php

/**
 * The YAML filter serializes data into YAML string form.
 * This filter can be loaded by default as not all cache layers
 * support storing PHP objects.
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Filter_XML implements Filter, Serializer
{
	private $serializer;
	private $unserializer;

	/**
	* Initialise a new YAML filter.
	*/
	public function __construct($config)
	{
		@include_once 'XML/Serializer.php';
		@include_once 'XML/Unserializer.php';

		if (!class_exists('XML_Serializer') || !class_exists('XML_Unserializer'))
			throw new Exception('The XML filter requires the Pear::XML_Serializer library.');

		$this->serializer = new XML_Serializer(array(
			XML_SERIALIZER_OPTION_TYPEHINTS		=> true,
			XML_SERIALIZER_OPTION_RETURN_RESULT 	=> true,
		));

		$this->unserializer = new XML_Unserializer(array(
			XML_UNSERIALIZER_OPTION_RETURN_RESULT	=> true,
		));
	}

	public function encode($data)
	{
		return $this->serializer->serialize($data);
	}

	public function decode($data)
	{
		return $this->unserializer->unserialize($data, false);
	}
}
